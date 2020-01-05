<?php

session_start();

header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Credentials: true");

$reply = (object)[];

if (! isset($_SESSION['user_id'])) {
	$reply->status = false;
	$reply->message = "Not logged in";
	die();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ai23', 'root', '');        
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

$statement = $pdo->prepare("SELECT name, edad, sex, ocupacion, pic FROM users WHERE id = :id");
$statement->bindValue(":id", $_SESSION['user_id']);
$statement->execute();
$reply = $statement->fetchAll(PDO::FETCH_ASSOC);

$json = json_encode($reply[0]);
echo $json;

die();

?>