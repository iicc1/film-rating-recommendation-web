<?php

session_start();

header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Credentials: true");

$reply = (object)[];
if (! isset($_SESSION['user_id'])) {
    $reply->status = false;
    $reply->message = "Not logged in";
    $json = json_encode($reply);
    echo $json; 
    die();
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ai23', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

$reply->status = true;

$statement = $pdo->prepare("SELECT * FROM movie INNER JOIN moviegenre
ON moviegenre.movie_id = movie.id INNER JOIN genre
ON genre.id = moviegenre.genre_id WHERE movie.id = ?");
$statement->execute([$_GET['id']]);
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

$reply->movie = $results[0];

$statement = $pdo->prepare("SELECT * FROM moviecomments INNER JOIN users
ON moviecomments.user_id = users.id WHERE movie_id = ?");
$statement->execute([$_GET['id']]);
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);

$reply->comments = $comments;


$json = json_encode($reply);
echo $json;

die();
?>