<?php
require_once "./include/config.php";
require_once "./include/ShortUrl.php";

if ($_SERVER["REQUEST_METHOD"] != "POST" || empty($_POST["url"])) {
    http_response_code(412);
    exit;
}

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
    $code = $shortUrl->urlToShortCode($_POST["url"]);
}
catch (\Exception $e) {
    http_response_code(500);
    exit;
}
$url = SHORTURL_PREFIX . $code;

echo "{ \"url\": \"" . $url . "\" }";
