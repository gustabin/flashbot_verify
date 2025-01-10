<?php
// Incluir el archivo de configuración de la base de datos
require '../tools/mypathdb.php';

// Establecer el tipo de contenido de la respuesta como JSON
header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Length: 0");
    header("Connection: close");
    http_response_code(200); // Responder con un estado 200 para preflight
    exit;
}


// Leer el cuerpo de la solicitud JSON
$data = json_decode(file_get_contents("php://input"), true);

// Verificar si la clave API fue enviada en la solicitud JSON
if (!isset($data['apiKey'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta la apiKey en la solicitud.']);
    exit;
}

// Inicializar la respuesta
$response = array();

// Reportar errores de MySQL
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Conectar a la base de datos
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $mysqli->set_charset("utf8mb4");

    // Verificar si hubo un error de conexión
    if ($mysqli->connect_error) {
        throw new Exception('Error de conexión: ' . $mysqli->connect_error);
    }

    // Obtener la clave API de los datos decodificados
    $api_key = $data['apiKey'];

    // Consulta para verificar si la clave API existe en la base de datos
    $query = "SELECT id, name, email, passwordhash, website, hostDB, userDB, passwordDB, databaseDB, typeDB, portDB, ssl_enabledDB, charsetDB, contenido
              FROM user WHERE api_key = ?";

    // Preparar la consulta
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al preparar la consulta: ' . $mysqli->error]);
        exit();
    }

    // Vincular la clave API al parámetro de la consulta
    $stmt->bind_param('s', $api_key);
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Verificar si se encontró un registro con la clave API
    if ($row = $result->fetch_assoc()) {
        // Devolver los datos del usuario en formato JSON
        echo json_encode([
            'name' => $row['name'],
            'hostDB' => $row['hostDB'],
            'userDB' => $row['userDB'],
            'passwordDB' => $row['passwordDB'],
            'databaseDB' => $row['databaseDB'],
            'typeDB' => $row['typeDB'],
            'portDB' => $row['portDB'],
            'ssl_enabledDB' => $row['ssl_enabledDB'],
            'charsetDB' => $row['charsetDB'],
            'contenido' => $row['contenido']
        ]);
    } else {
        // Si no se encontró un registro, devolver un error 401
        http_response_code(401);
        echo json_encode(['error' => 'API key inválida']);
    }

    // Cerrar la conexión a la base de datos si está abierta
    if ($mysqli) {
        $mysqli->close();
    }
} catch (Exception $e) {
    // Capturar excepciones y devolver un mensaje de error
    http_response_code(500); // Código de error interno
    echo json_encode(['error' => $e->getMessage()]);
}
