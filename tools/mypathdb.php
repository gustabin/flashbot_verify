<?php
// Cargar configuraciones desde .env
require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Detectar el entorno (localhost o remoto)
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Configuración de la base de datos para entorno local
    if (!defined('DB_HOST')) {
        define('DB_HOST', getenv('DB_HOST_LOCAL'));
    }
    if (!defined('DB_USER')) {
        define('DB_USER', getenv('DB_USER_LOCAL'));
    }
    if (!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', getenv('DB_PASSWORD_LOCAL'));
    }
    if (!defined('DB_NAME')) {
        define('DB_NAME', getenv('DB_NAME_LOCAL'));
    }
} elseif ($_SERVER['SERVER_NAME'] == 'chatpana.com' || $_SERVER['SERVER_NAME'] == 'www.chatpana.com') {
    // Configuración de la base de datos para entorno remoto
    if (!defined('DB_HOST')) {
        define('DB_HOST', getenv('DB_HOST_REMOTE'));
    }
    if (!defined('DB_USER')) {
        define('DB_USER', getenv('DB_USER_REMOTE'));
    }
    if (!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', getenv('DB_PASSWORD_REMOTE'));
    }
    if (!defined('DB_NAME')) {
        define('DB_NAME', getenv('DB_NAME_REMOTE'));
    }
}

// Configuración del servidor SMTP
if (!defined('SMTP_USERNAME')) {
    define('SMTP_USERNAME', getenv('SMTP_USERNAME'));
}
if (!defined('SMTP_PASSWORD')) {
    define('SMTP_PASSWORD', getenv('SMTP_PASSWORD'));
}
if (!defined('SMTP_HOST')) {
    define('SMTP_HOST', getenv('SMTP_HOST'));
}
if (!defined('SMTP_PORT')) {
    define('SMTP_PORT', getenv('SMTP_PORT'));
}
