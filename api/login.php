<?php

//session_set_cookie_params(99999, '/', '127.0.0.1');
session_start();

header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Credentials: true");

$data = json_decode(file_get_contents('php://input'), true);

$name = $data["name"];
$password = $data["password"];


try {
    $pdo = new PDO('mysql:host=localhost;dbname=ai23', 'root', '');        
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

$stmt = $pdo->prepare("SELECT id, passwd FROM users WHERE name = :name");
$stmt->bindValue(":name", $name);
$stmt->execute();

$data = (object)[];

$row = $stmt->fetch();
if (password_verify($password, $row["passwd"])) {
    $data->status = true;
    $_SESSION['user_id'] = $row["id"];
} else {
	$data->status = false;
}

$json = json_encode($data);
echo $json;

die();

?>