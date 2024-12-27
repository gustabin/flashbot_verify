# Flashbot Chatbot Integration

Flashbot es un chatbot personalizable diseñado para integrarse fácilmente en tu sitio web y proporcionar una experiencia interactiva con soporte para validación de claves API y configuración de bases de datos dinámicas.

## Características principales

- **Validación de claves API:** Seguridad incorporada para validar el acceso a través de claves API únicas.
- **Configuración dinámica de bases de datos:** Integra conexiones a bases de datos locales o remotas según el entorno.
- **Interfaz de usuario interactiva:** Contenedor de chatbot personalizable con entrada y salida de mensajes.
- **Conexión al backend Python:** Comunicación fluida con el servidor Python para la gestión de consultas.

## Requisitos

### Cliente
- Navegador moderno compatible con JavaScript.

### Servidor
- PHP 7.4 o superior.
- MySQL 5.7 o superior.
- Archivo `.env` con las configuraciones necesarias (detalles más abajo).

## Instalación

### 1. Clona este repositorio
```bash
git clone https://github.com/tu-usuario/flashbot.git
cd flashbot
```

### 2. Configura el entorno
Crea un archivo `.env` en el directorio raíz con las siguientes variables:

```env
# Configuración local
DB_HOST_LOCAL=localhost
DB_USER_LOCAL=root
DB_PASSWORD_LOCAL=tu_contraseña
DB_NAME_LOCAL=flashbot_db

# Configuración remota
DB_HOST_REMOTE=tu_servidor_remoto
DB_USER_REMOTE=tu_usuario
DB_PASSWORD_REMOTE=tu_contraseña
DB_NAME_REMOTE=flashbot_db

# Configuración SMTP
SMTP_USERNAME=tu_usuario_smtp
SMTP_PASSWORD=tu_contraseña_smtp
SMTP_HOST=tu_servidor_smtp
SMTP_PORT=587
```

### 3. Instala dependencias
Asegúrate de tener [Composer](https://getcomposer.org/) instalado y ejecuta:
```bash
composer install
```

### 4. Configura la base de datos
Ejecuta el script SQL proporcionado (si corresponde) para crear las tablas necesarias en tu base de datos.

## Uso

### Incrustar el chatbot en tu sitio web
Agrega el siguiente código en tu archivo HTML, reemplazando `TU_API_KEY` con tu clave API válida:

```html
<script src="path/to/chatbot.js" data-api-key="TU_API_KEY"></script>
```

### Validación de la clave API
El script validará automáticamente la clave API al cargar y configurará el chatbot según los datos asociados.

### Backend PHP
El archivo `php/validate-api-key.php` maneja la validación de claves API y devuelve las credenciales de base de datos necesarias para la configuración.

### Configuración dinámica
El archivo `tools/mypathdb.php` detecta el entorno (local o remoto) y configura las credenciales de base de datos correspondientes.

## Arquitectura del proyecto

```plaintext
/
├── chatbot.js                # Script principal del chatbot
├── php/
│   ├── validate-api-key.php  # Endpoint de validación de claves API
├── tools/
│   ├── mypathdb.php          # Configuración de conexión a la base de datos
├── vendor/                   # Dependencias de Composer
└── .env                      # Configuración del entorno (excluido del repositorio)
```

## Personalización

Puedes modificar el diseño y la posición del chatbot editando las siguientes secciones del archivo `chatbot.js`:

- **Contenedor del chatbot:** Estilos iniciales definidos en `chatContainer`.
- **Botón de apertura:** Estilos definidos en `openButton`.

## Seguridad

- Asegúrate de proteger tu archivo `.env` y nunca lo incluyas en el repositorio.
- Usa HTTPS para todas las comunicaciones entre el cliente y el servidor.

## Licencia
Este proyecto está bajo la Licencia MIT. Consulta el archivo `LICENSE` para más detalles.

## Contribuciones
Las contribuciones son bienvenidas. Por favor, crea un issue o un pull request para discutir cambios.
