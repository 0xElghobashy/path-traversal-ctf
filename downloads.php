<?php

$file = $_GET['file'];

$path = __DIR__ . '/documents/' . $file ;

if (file_exists($path)) {
    header('Content-Type: application=octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    readfile($path);
} else {
    http_response_code(404);
    echo "File not found.";
}
