<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/api/config/constants.php';

$route = $_GET['route'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

switch (true) {
    case ($route === 'checkout' && $method === 'POST'):
        require_once __DIR__ . '/api/controllers/CheckoutController.php';
        $controller = new CheckoutController();
        $request = json_decode(file_get_contents('php://input'), true);
        $response = $controller->createCheckout($request);
        echo json_encode($response);
        break;
    case ($route === 'checkout' && $method === 'GET'):
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
    case ($route === 'notifications' && $method === 'POST'):
        require_once __DIR__ . '/api/controllers/NotificationController.php';
        $controller = new NotificationController();
        $request = json_decode(file_get_contents('php://input'), true);
        $response = $controller->handleNotification($request);
        echo json_encode($response);
        break;
    case ($route === 'notifications' && $method === 'GET'):
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
        break;
}
