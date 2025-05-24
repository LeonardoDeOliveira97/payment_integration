<?php
require_once __DIR__ . '/../models/paymentModel.php';

function createPayment()
{
    $data = json_decode(file_get_contents('php://input'), true);
    $result = processPayment($data);
    echo json_encode($result);
}
