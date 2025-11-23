<?php
$nextjs_url = "http://localhost:3000" . $_SERVER['REQUEST_URI'];

// Forward headers
$headers = [];
foreach (getallheaders() as $name => $value) {
    $headers[] = "$name: $value";
}

// Fetch Next.js response
$options = [
    "http" => [
        "header" => implode("\r\n", $headers),
        "method" => $_SERVER['REQUEST_METHOD'],
        "content" => file_get_contents("php://input")
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($nextjs_url, false, $context);

// Return response
http_response_code($http_response_header[0] ?? 200);
echo $response;
