<?php

session_start();

header("Access-Control-Allow-Origin: http://localhost:8080");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Credentials: true");


$data = json_decode(file_get_contents('php://input'), true);

$pic = $data["pic"];
$age = $data["age"];
$gender = $data["gender"];
$occupation = $data["occupation"];
$password1 = $data["password1"];
$password2 = $data["password2"];

$reply = (object)[];
if (! isset($_SESSION['user_id'])) {
	//echo json_encode($_SESSION);
	$reply->status = false;
	$reply->message = "Not logged in";
	$json = json_encode($reply);
	echo $json; 
	die();
}

if (strlen($age) < 1 && strlen($gender) < 1 && strlen($occupation) < 1) {
	$reply->status = false;
	$reply->message = "Missing form fields";
	$json = json_encode($reply);
	echo $json;
	die();
} else if ($password1 !== $password2) {
	$reply->status = false;
	$reply->message = "Password missmatch";
	$json = json_encode($reply);
	echo $json;
	die();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ai23', 'root', '');        
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

// Updates the user data
try {
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = 'UPDATE users SET edad = ?, sex = ?, ocupacion = ?, pic = ? WHERE id = ?';
	$pdo->prepare($query)->execute([$age, $gender, $occupation, $pic, $_SESSION['user_id']]);
	$reply->status = true;
  } catch (Exception $e) {
  	$reply->status = false;
  	$reply->message = $e->getMessage();
  } finally {
  	$json = json_encode($reply);
  	echo $json;
  	die();
  }

// TODO if password1 != password 2: update hash
?>