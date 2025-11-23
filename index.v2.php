<?php
$nodePath = "/home/u408839980/_ws/node-v22.11.0-linux-x64/bin/node";
$serverScript = "/home/u408839980/nodejs/index.js";
$pidFile = "/home/u408839980/myapp/node.pid";

// Start Node.js if not running
if (!file_exists($pidFile) || !posix_kill(file_get_contents($pidFile), 0)) {
    $cmd = "$nodePath $serverScript > /dev/null 2>&1 & echo $!";
    $pid = exec($cmd);
    file_put_contents($pidFile, $pid);
}

// Proxy the request
$nextjs_url = "http://localhost:3000" . $_SERVER['REQUEST_URI'];
$ch = curl_init($nextjs_url);

// Forward method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $_SERVER['REQUEST_METHOD']);

// Forward headers
$headers = [];
foreach (getallheaders() as $name => $value) {
    $headers[] = "$name: $value";
}
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Forward body (for POST, PUT, PATCH)
$input = file_get_contents("php://input");
if ($input) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
}

// Return headers and body
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// Split headers and body
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);

// Forward headers
foreach (explode("\r\n", $header) as $h) {
    if (stripos($h, 'transfer-encoding') === false && !empty($h)) {
        header($h);
    }
}

// Output body
echo $body;
curl_close($ch);
