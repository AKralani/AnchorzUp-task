<?php
require_once('config.php');

$mysqli = new mysqli($hostname, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function generateShortUrl($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $shortUrl = '';
    for ($i = 0; $i < $length; $i++) {
        $shortUrl .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $shortUrl;
}

if (isset($_GET['getShortLinks'])) {
    $shortLinks = [];

    $stmt = $mysqli->prepare("SELECT short_url FROM short_urls");
    $stmt->execute();
    $stmt->bind_result($shortUrl);

    while ($stmt->fetch()) {
        $shortLinks[] = ["shortUrl" => "http://localhost/anchorzup/$shortUrl"];
    }

    $stmt->close();

    echo json_encode(['shortLinks' => $shortLinks]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $originalUrl = $data['url'];
    $expirationTime = time() + (int)$data['expiration']; // Parse and set the expiration time

    $shortUrl = generateShortUrl();

    $stmt = $mysqli->prepare("INSERT INTO short_urls (short_url, original_url, expiration_time) VALUES (?, ?, ?)");
    $expirationTimestamp = date('Y-m-d H:i:s', $expirationTime);
    $stmt->bind_param("sss", $shortUrl, $originalUrl, $expirationTimestamp);

    if ($stmt->execute()) {
        echo json_encode(['shortUrl' => "http://localhost/anchorzup/$shortUrl"]);
    } else {
        echo 'Error: Unable to create the short URL.';
    }
    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['url'])) {
    $shortUrl = $_GET['url'];

    $stmt = $mysqli->prepare("SELECT original_url, expiration_time FROM short_urls WHERE short_url = ?");
    $stmt->bind_param("s", $shortUrl);
    $stmt->execute();
    $stmt->bind_result($originalUrl, $expirationTime);

    if ($stmt->fetch()) {
        if ($expirationTime === null || time() < strtotime($expirationTime)) {
            header("Location: $originalUrl", true, 301);
            exit();
        } else {
            echo 'Short URL has expired.';
        }
    } else {
        echo 'Short URL not found.';
    }
    $stmt->close();
}

$mysqli->close();
?>