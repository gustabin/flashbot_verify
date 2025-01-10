<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Dotenv\Dotenv;

session_start();

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
try {
    $dotenv->load();
} catch (Exception $e) {
    die("Error al cargar .env: " . $e->getMessage());
}

// Detectar el entorno (localhost o remoto)
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Configuración de la base de datos para entorno local
    if (!defined('DB_HOST')) {
        define('DB_HOST',  $_ENV['DB_HOST_LOCAL']);
    }
    if (!defined('DB_USER')) {
        define('DB_USER', $_ENV['DB_USER_LOCAL']);
    }
    if (!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', $_ENV['DB_PASSWORD_LOCAL']);
    }
    if (!defined('DB_NAME')) {
        define('DB_NAME', $_ENV['DB_NAME_LOCAL']);
    }
} elseif ($_SERVER['SERVER_NAME'] == 'chatpana.com' || $_SERVER['SERVER_NAME'] == 'www.chatpana.com') {
    // Configuración de la base de datos para entorno remoto
    if (!defined('DB_HOST')) {
        define('DB_HOST', $_ENV['DB_HOST_REMOTE']);
    }
    if (!defined('DB_USER')) {
        define('DB_USER', $_ENV['DB_USER_REMOTE']);
    }
    if (!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', $_ENV['DB_PASSWORD_REMOTE']);
    }
    if (!defined('DB_NAME')) {
        define('DB_NAME', $_ENV['DB_NAME_REMOTE']);
    }
}

// Configuración del servidor SMTP
if (!defined('SMTP_USERNAME')) {
    define('SMTP_USERNAME', $_ENV['SMTP_USERNAME']);
}
if (!defined('SMTP_PASSWORD')) {
    define('SMTP_PASSWORD', $_ENV['SMTP_PASSWORD']);
}
if (!defined('SMTP_HOST')) {
    define('SMTP_HOST', $_ENV['SMTP_HOST']);
}
if (!defined('SMTP_PORT')) {
    define('SMTP_PORT', $_ENV['SMTP_PORT']);
}
