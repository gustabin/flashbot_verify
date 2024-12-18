<?php
require __DIR__ . './../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configuración de la base de datos
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define('DB_HOST', $_ENV['DB_HOST']);
    define('DB_USER', $_ENV['DB_USER']);
    define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
    define('DB_NAME', $_ENV['DB_NAME']);
} elseif ($_SERVER['SERVER_NAME'] == 'chatpana.com' || $_SERVER['SERVER_NAME'] == 'www.chatpana.com') {
    define('DB_HOST', $_ENV['REMOTE_DB_HOST']);
    define('DB_USER', $_ENV['REMOTE_DB_USER']);
    define('DB_PASSWORD', $_ENV['REMOTE_DB_PASSWORD']);
    define('DB_NAME', $_ENV['REMOTE_DB_NAME']);
}

// Configuración del servidor SMTP
define('SMTP_USERNAME', $_ENV['SMTP_USERNAME']);
define('SMTP_PASSWORD', $_ENV['SMTP_PASSWORD']);
define('SMTP_HOST', $_ENV['SMTP_HOST']);
define('SMTP_PORT', $_ENV['SMTP_PORT']);
