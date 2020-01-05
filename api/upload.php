<?php
include 'utils.php';

session_start();

header("Access-Control-Allow-Origin: http://localhost:8080");
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

$extension = getExtension($_FILES["image"]["type"]);
$randomString = generateRandomString() . $extension;

$moved = move_uploaded_file($_FILES["image"]["tmp_name"], "images/profiles/" . $randomString);

if ($moved) {
	$reply->status = true;     
} else {
	echo "Not uploaded because of error #" . $_FILES["file"]["error"];
	/*
    UPLOAD_ERR_INI_SIZE = Value: 1; The uploaded file exceeds the upload_max_filesize directive in php.ini.
    UPLOAD_ERR_FORM_SIZE = Value: 2; The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.
    UPLOAD_ERR_PARTIAL = Value: 3; The uploaded file was only partially uploaded.
    UPLOAD_ERR_NO_FILE = Value: 4; No file was uploaded.
    UPLOAD_ERR_NO_TMP_DIR = Value: 6; Missing a temporary folder. Introduced in PHP 5.0.3.
    UPLOAD_ERR_CANT_WRITE = Value: 7; Failed to write file to disk. Introduced in PHP 5.1.0.
    UPLOAD_ERR_EXTENSION = Value: 8; A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.
	*/
    die();
}

// Save to DB
try {
    $pdo = new PDO('mysql:host=localhost;dbname=ai23', 'root', '');        
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

$query = 'UPDATE users SET pic = ? WHERE id = ?';
$pdo->prepare($query)->execute([$randomString, $_SESSION['user_id']]);

?>