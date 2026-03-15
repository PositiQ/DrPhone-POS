<?php
require_once __DIR__ . '/components/UI/auth.php';
pos_boot_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);

if (!is_array($payload) || empty($payload['token']) || empty($payload['user']) || !is_array($payload['user'])) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid payload']);
    exit;
}

pos_store_auth_session([
    'token' => $payload['token'],
    'user' => $payload['user'],
]);

header('Content-Type: application/json');
echo json_encode(['success' => true]);
