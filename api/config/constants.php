<?php

$envPath = __DIR__ . '/../../.env';

if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        putenv(trim($line));
    }
}

define('PAGBANK_TOKEN', getenv('PAGBANK_TOKEN'));
define('PAGBANK_CHECKOUT_URL', getenv('PAGBANK_CHECKOUT_URL'));
