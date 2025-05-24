<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // ou o domínio autorizado
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/api/config/constants.php';
require_once __DIR__ . '/api/routes/paymentRoutes.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


switch ($uri) {
    case '/api/payment':
        if ($method === 'POST') {
            require_once __DIR__ . '/api/controllers/paymentController.php';
            createPayment();
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido']);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint não encontrado']);
        break;
}
