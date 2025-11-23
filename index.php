<?php
header('Content-Type: text/html'); // match the content type of the proxied resource

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $url = 'http://localhost:5173/'; // the URL you want to fetch

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects
    curl_setopt($ch, CURLOPT_HEADER, false); // don't include headers in output

    $response = curl_exec($ch);

    if ($response === false) {
        http_response_code(500);
        echo "Error fetching the URL: " . curl_error($ch);
    } else {
        echo $response;
    }

    curl_close($ch);
} else {
    http_response_code(405);
    echo "Method not allowed";
}
