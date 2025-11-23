<?php
$nextjs_url = 'http://localhost:8080' . $_SERVER['REQUEST_URI'];
$ch = curl_init($nextjs_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
echo $response;
