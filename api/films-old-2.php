<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ai23', 'root', '');        
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

$query = "SELECT * FROM movie";
if (isset($_GET['query'])) {
	$query = "SELECT * FROM movie WHERE title LIKE '%" . $_GET['query'] . "%'";
}

$statement = $pdo->prepare($query);
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

$json = json_encode($results);
echo $json;

$result = null;
$pdo = null;

?>