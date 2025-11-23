<?php
// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // allow requests from anywhere
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Simple routing
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $users = [
        ['id' => 1, 'name' => 'Ahmed'],
        ['id' => 2, 'name' => 'Sara'],
    ];
    echo json_encode($users);
} elseif ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $response = [
        'status' => 'success',
        'received' => $input
    ];
    echo json_encode($response);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
