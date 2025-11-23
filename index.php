<?php
// URL of the Node.js server
$nodeUrl = 'http://localhost:3000/api/data' . $_SERVER['REQUEST_URI'];

// Initialize cURL
$ch = curl_init($nodeUrl);

// Forward request method (GET, POST, PUT, DELETE)
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $_SERVER['REQUEST_METHOD']);

// Forward request body for POST/PUT/PATCH
$input = file_get_contents('php://input');
if ($input) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
}

// Forward headers from client
$headers = [];
foreach (getallheaders() as $key => $value) {
    $headers[] = "$key: $value";
}
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Return the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute request
$response = curl_exec($ch);

// Forward HTTP status code
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
http_response_code($httpCode);

// Forward response body
echo $response;

// Close cURL
curl_close($ch);
