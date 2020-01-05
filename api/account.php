<?php

session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("credentials: 'include'");


$data = (object)[];

if (! isset($_SESSION['user_id'])) {
   $data->status = false;
   $data->message = "Not logged in";
   die();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ai23', 'root', '');        
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

$statement = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$statement->bindValue(":id", $_SESSION['user_id']);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

$json = json_encode($data[0]);
echo $json;

die();

?>