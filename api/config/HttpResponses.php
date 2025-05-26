<?php

class httpResponses
{
    public static function send($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        isset($data['status']) ?? $data['status'] = true;
        echo json_encode($data);
        exit;
    }

    public static function sendError($message, $statusCode = 400)
    {
        header('Content-Type: application/json');
        self::send(['status' => false, 'error' => $message], $statusCode);
    }
}
