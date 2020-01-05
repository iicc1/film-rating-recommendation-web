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

$data = [];
for ($i = 0; $i < count($results); ++$i) {
	if ($i < 50) {
		$data[0][$i] = $results[$i];
	} elseif ($i < 500) {
		$data[1][$i] = $results[$i];
	} elseif ($i < 800) {
		$data[2][$i] = $results[$i];
	} elseif ($i < 1200) {
		$data[3][$i] = $results[$i];
	} else {
		$data[4][$i] = $results[$i];
	}
}

$json = json_encode($data);
echo $json;

$result = null;
$pdo = null;

?>