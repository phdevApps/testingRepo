<?php
$nodePath = "/home/u408839980/_ws/node-v22.11.0-linux-x64/bin/node";
$serverScript = "/home/u408839980/nodejs/index.js";
$pidFile = "/home/u408839980/myapp/node.pid";

// Check if Node.js is already running
if (!file_exists($pidFile) || !posix_kill(file_get_contents($pidFile), 0)) {
    // Start Node.js in background
    $cmd = "$nodePath $serverScript > /dev/null 2>&1 & echo $!";
    $pid = exec($cmd);
    file_put_contents($pidFile, $pid);
}

// Now you can proxy the request to Node.js as usual
$nextjs_url = "http://localhost:3000" . $_SERVER['REQUEST_URI'];
$ch = curl_init($nextjs_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
echo $response;
