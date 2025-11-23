<?php
$nextjs_url = "http://localhost:3000" . $_SERVER['REQUEST_URI'];

$ch = curl_init($nextjs_url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $_SERVER['REQUEST_METHOD']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Forward POST/PUT data
$input = file_get_contents("php://input");
if ($input) curl_setopt($ch, CURLOPT_POSTFIELDS, $input);

// Forward headers
$headers = [];
foreach (getallheaders() as $name => $value) {
    $headers[] = "$name: $value";
}
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Execute request
$response = curl_exec($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);

// Forward response headers
foreach (explode("\r\n", $header) as $h) {
    if (stripos($h, 'transfer-encoding') === false && !empty($h)) {
        header($h);
    }
}

echo $body;
curl_close($ch);
