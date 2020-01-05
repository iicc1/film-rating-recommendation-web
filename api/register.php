<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


$data = json_decode(file_get_contents('php://input'), true);

$name = $data["name"];
$age = $data["age"];
$gender = $data["gender"];
$occupation = $data["occupation"];
$password1 = $data["password1"];
$password2 = $data["password2"];

$reply = (object)[];

if (strlen($name) < 1 && strlen($age) < 1 && strlen($gender) < 1 && strlen($occupation) < 1 && strlen($password1) < 1 && strlen($password2) < 1) {
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

// Checks if the user already exists in the database
$stmt = $pdo->prepare("SELECT id FROM users WHERE name = :name");
$stmt->bindValue(":name", $name);
$stmt->execute();

if ($stmt->rowCount() > 0) {
	$reply->status = false;
	$reply->message = "This name already exists";
	$json = json_encode($reply);
	echo $json;
	die();
}

// Inserts the new user into the database
try {
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = 'INSERT INTO users (name, edad, sex, ocupacion, passwd) VALUES (?,?,?,?,?)';
	$pdo->prepare($query)->execute([$name, $age, $gender, $occupation, password_hash($password1, PASSWORD_BCRYPT)]);
	$reply->status = true;
	$json = json_encode($reply);
	echo $json; 
  }
  catch (Exception $e) {
  	$reply->status = false;
  	$reply->message = $e->getMessage();
  } finally {
  	die();
  }
?>