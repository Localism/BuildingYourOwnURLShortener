<?php
require_once "./include/config.php";
require_once "./include/ShortUrl.php";

if (empty($_GET["q"])) {
    http_response_code(412);
    exit;
} 

$code = $_GET["q"];

try {
    $pdo = new PDO(DB_PDODRIVER . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE,
        DB_USERNAME, DB_PASSWORD);
}
catch (\PDOException $e) {
    http_response_code(500);
    exit;
}

$shortUrl = new ShortUrl($pdo);
try {
    $url = $shortUrl->shortCodeToUrl($code);
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $url);
}
catch (\Exception $e) {
    print_r($e);
    http_response_code(500);
    exit;
}
