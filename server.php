<?php

$publicPath = __DIR__.'/public';
$requestedPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$requestedFile = $requestedPath ? $publicPath.$requestedPath : $publicPath;

if ($requestedPath !== '/' && $requestedPath && file_exists($requestedFile) && ! is_dir($requestedFile)) {
    return false;
}

require_once $publicPath.'/index.php';
