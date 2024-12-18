<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Configuración de la base de datos
    if (!defined('DB_HOST')) {
        define('DB_HOST', 'localhost');
    }
    if (!defined('DB_USER')) {
        define('DB_USER', 'root');
    }
    if (!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', '');
    }
    if (!defined('DB_NAME')) {
        define('DB_NAME', 'echodb');
    }
}

// remoto
if (($_SERVER['SERVER_NAME'] == 'chatpana.com') or ($_SERVER['SERVER_NAME'] == 'www.chatpana.com')) {
    // Configuración de la base de datos
    if (!defined('DB_HOST')) {
        define('DB_HOST', 'localhost');
    }
    if (!defined('DB_USER')) {
        define('DB_USER', 'chatpana_regente');
    }
    if (!defined('DB_PASSWORD')) {
        define('DB_PASSWORD', '$h1=9#-j!iG*');
    }
    if (!defined('DB_NAME')) {
        define('DB_NAME', 'chatpana_echodb');
    }
}


// Configuración del servidor SMTP
if (!defined('SMTP_USERNAME')) {
    define('SMTP_USERNAME', 'ventas@chatpana.com');
}
if (!defined('SMTP_PASSWORD')) {
    define('SMTP_PASSWORD', 'Kto#[@2h;nQP');
}
if (!defined('SMTP_HOST')) {
    define('SMTP_HOST', 'mail.chatpana.com');
}
if (!defined('SMTP_PORT')) {
    define('SMTP_PORT', 465);
}
