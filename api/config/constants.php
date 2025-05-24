<?php

$envPath = __DIR__ . '/../../.env';

if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        putenv(trim($line));
    }
}

define('PAGBANK_SECRET_KEY', getenv('PAGBANK_SECRET_KEY'));
define('PAGBANK_PUBLIC_KEY', getenv('PAGBANK_PUBLIC_KEY'));
define('PAGBANK_API_KEY', getenv('PAGBANK_API_KEY'));
define('PAGBANK_API_URL', getenv('PAGBANK_API_URL'));
define('PAGBANK_API_VERSION', getenv('PAGBANK_API_VERSION'));
define('PAGBANK_API_TIMEOUT', getenv('PAGBANK_API_TIMEOUT'));
