<?php

session_start();

header("Access-Control-Allow-Origin: http://localhost:8080");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Credentials: true");


$reply = (object)[];
if (! isset($_SESSION['user_id'])) {
	//echo json_encode($_SESSION);
	$reply->status = false;
	$reply->message = "Not logged in";
	$json = json_encode($reply);
	echo $json; 
	die();
}

if (! isset($_GET['film_id'])) {
	//echo json_encode($_SESSION);
	$reply->status = false;
	$reply->message = "Film id not found";
	$json = json_encode($reply);
	echo $json; 
	die();
}

if (! isset($_GET['score'])) {
	//echo json_encode($_SESSION);
	$reply->status = false;
	$reply->message = "Score not found";
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
    $query = 'REPLACE INTO user_score (id_user, id_movie, score) VALUES (?,?,?)';
	$pdo->prepare($query)->execute([$_SESSION['user_id'], $_GET['film_id'] ,$_GET['score']]);
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