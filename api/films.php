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
$films = $statement->fetchAll(PDO::FETCH_ASSOC);


$total_rating_count = 0;
$total_rating_avg = 0;
for ($i = 0; $i < count($films); ++$i) {
	$statement = $pdo->prepare("SELECT COUNT(*) as count, AVG(score) as avg FROM user_score WHERE id_movie = ?");
	$statement->execute([$films[$i]["id"]]);
	$rating = $statement->fetchAll(PDO::FETCH_ASSOC);
	$films[$i]["rating_count"] = (float) $rating[0]["count"];
	$films[$i]["rating_avg"] = (float) $rating[0]["avg"];
	$films[$i]["rating_avg_short"] = number_format($rating[0]["avg"], 2);
	$total_rating_count++;
	$total_rating_avg += $rating[0]["avg"];

	$statement = $pdo->prepare("SELECT genre_name FROM movie INNER JOIN moviegenre ON moviegenre.movie_id = movie.id INNER JOIN genre ON genre.id = moviegenre.genre_id WHERE movie.id = ?");
	$statement->execute([$films[$i]["id"]]);
	$genre = $statement->fetchAll(PDO::FETCH_ASSOC);
	$films[$i]["genre"] = $genre[0]["genre_name"];
}
$total_rating_avg = $total_rating_avg / $total_rating_count;

// Bayesian Ranking
for ($i = 0; $i < count($films); ++$i) {
	$rating_bayesian1 = $total_rating_count * $total_rating_avg + $films[$i]["rating_count"] * $films[$i]["rating_avg"];
	$rating_bayesian2 = $total_rating_count * $films[$i]["rating_count"];
	$rating_bayesian = $rating_bayesian1 / $rating_bayesian2;
	$films[$i]["rating_bayesian"] = $rating_bayesian;
}

$json = json_encode($films);
echo $json;

$result = null;
$pdo = null;

?>