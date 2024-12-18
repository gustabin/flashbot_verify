(function () {
    async function validateApiKey() {
        const apiKey = document.currentScript.getAttribute('data-api-key'); // Obtener la clave API desde el script
        if (!apiKey) {
            alert('API key is missing. Please provide a valid API key.'); // Mensaje de error si falta la clave API
            return;
        }

        try {
            // Enviar la clave API al servidor para validarla
            const response = await fetch('https://chatpana.com/flashbot_verify/php/validate-api-key.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json' // Especificar que el cuerpo es JSON
                },
                body: JSON.stringify({ apiKey }) // Enviar la clave API en formato JSON
            });

            if (response.ok) {
                const dbData = await response.json(); // Obtener datos de la respuesta JSON
                console.log('Welcome to the party!'); // Mensaje de bienvenida al usuario

                // Configurar la conexión con el servidor Python
                const connectionSuccessful = await setupPythonConnection(dbData);
                if (connectionSuccessful) {
                    // Si la conexión es exitosa, mostrar el contenedor del chatbot
                    chatContainer.style.display = 'block';
                } else {
                    console.error('Error establishing connection to Python. Chatbot won\'t be displayed.'); // Mensaje de error si la conexión falla
                }
            } else {
                const errorData = await response.json(); // Obtener mensaje de error del servidor
                alert(`Error: La API key es inválida: ${errorData.error}`); // Alertar al usuario sobre la clave API inválida
            }
        } catch (error) {
            alert('Hubo un problema al procesar la solicitud.'); // Alertar al usuario si hay un problema en la solicitud
        }
    }

    // Función para configurar la conexión con el servidor Python
    async function setupPythonConnection(dbData) {
        try {
            // Enviar datos al servidor Python para configurar el chatbot
            // const response = await fetch('http://127.0.0.1:5010/setup-db', {
            const response = await fetch('https://echodb-rlca.onrender.com/setup-db', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dbData)
            });

            if (response.ok) {
                openButton.style.display = 'block'; // Mostrar botón de abrir chatbot
                chatContainer.style.display = 'none'; // Mantener contenedor del chatbot oculto hasta que sea necesario
                return true; // Indicar que la conexión fue exitosa
            }
        } catch (error) {
            console.error('Error en la solicitud:', error); // Mostrar error en consola si falla la solicitud
            return false; // Indicar que la conexión falló
        }
    }

    // Crear y configurar el contenedor del chatbot
    const chatContainer = document.createElement('div');
    chatContainer.id = 'chatbot-container';
    chatContainer.style.position = 'absolute';
    chatContainer.style.bottom = '60px';
    chatContainer.style.right = '10px';
    chatContainer.style.width = '300px';
    chatContainer.style.border = '1px solid #ccc';
    chatContainer.style.borderRadius = '10px';
    chatContainer.style.boxShadow = '0 0 10px rgba(0, 0, 0, 0.1)';
    chatContainer.style.display = 'none'; // Inicialmente ocultar el contenedor

    // Crear y configurar el contenido inicial del chatbot
    const chatContent = document.createElement('div');
    chatContent.innerHTML = '<strong>🤖Flashbot</strong><br>¡Hola! Estoy aquí para ayudarte.';
    chatContent.style.padding = '10px';
    chatContent.style.backgroundColor = 'azure';
    chatContent.style.borderTopLeftRadius = '10px';
    chatContent.style.borderTopRightRadius = '10px';
    chatContainer.appendChild(chatContent); // Añadir contenido al contenedor

    // Crear y configurar el área de salida de chat
    const chatOutput = document.createElement('div');
    chatOutput.id = 'chat-output';
    chatOutput.style.height = '200px';
    chatOutput.style.overflowY = 'auto'; // Permitir desplazamiento si el contenido excede el área
    chatOutput.style.padding = '5px';
    chatContainer.appendChild(chatOutput); // Añadir área de salida al contenedor

    // Crear y configurar el área de entrada del usuario
    const userInput = document.createElement('textarea');
    userInput.id = 'user-input';
    userInput.placeholder = 'Escribe tu consulta aquí...'; // Mensaje de marcador de posición
    userInput.style.marginTop = '10px';
    userInput.style.marginLeft = '10px';
    userInput.style.marginRight = '10px';
    userInput.style.height = '80px';
    userInput.style.width = 'calc(100% - 42px)'; // Ajustar ancho
    chatContainer.appendChild(userInput); // Añadir área de entrada al contenedor

    // Crear y configurar el botón de enviar
    const sendButton = document.createElement('button');
    sendButton.innerText = 'Enviar';
    sendButton.id = 'send-button';
    sendButton.style.marginTop = '10px';
    sendButton.style.marginLeft = '10px';
    sendButton.style.marginBottom = '10px';
    sendButton.style.backgroundColor = 'dodgerblue';
    sendButton.disabled = true; // Deshabilitar botón hasta que haya un mensaje
    chatContainer.appendChild(sendButton); // Añadir botón al contenedor

    // Crear y configurar el loader (indicador de carga)
    const loader = document.createElement('img');
    loader.id = 'loader';
    loader.src = 'https://chatpana.com/flashbot_verify/static/img/barra.gif';
    loader.style.marginLeft = '10px';
    loader.style.display = 'none'; // Inicialmente ocultar el loader
    loader.style.width = '125px';
    chatContainer.appendChild(loader); // Añadir loader al contenedor

    // Agregar el contenedor de chat al body del documento
    document.body.appendChild(chatContainer);

    // Crear y configurar el botón para abrir/cerrar el chatbot
    const openButton = document.createElement('button');
    openButton.innerText = '💬';
    openButton.style.display = 'none'; // Inicialmente ocultar el botón
    openButton.style.position = 'absolute';
    openButton.style.bottom = '10px';
    openButton.style.paddingLeft = '10px';
    openButton.style.right = '30px';
    openButton.style.width = '50px';
    openButton.style.height = '50px';
    openButton.style.borderRadius = '50%'; // Hacer el botón redondeado
    openButton.style.border = 'none';
    openButton.style.backgroundColor = 'rgb(0, 123, 255)';
    openButton.style.color = 'rgb(255, 255, 255)';
    openButton.style.cursor = 'pointer';
    openButton.style.fontSize = '24px';

    document.body.appendChild(openButton); // Añadir botón al body

    // Evento al hacer clic en el botón de enviar
    sendButton.onclick = async () => {
        const message = userInput.value.trim(); // Obtener el mensaje del usuario
        if (!message) return; // No hacer nada si no hay mensaje

        loader.style.display = 'inline'; // Mostrar el loader
        try {
            // Enviar el mensaje al servidor para recibir respuesta
            // const response = await fetch('http://127.0.0.1:5010/chat', {
            const response = await fetch('https://echodb-rlca.onrender.com/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message }) // Enviar el mensaje como JSON
            });
            const data = await response.json(); // Obtener la respuesta del servidor

            // Manejo de errores en la respuesta
            if (data.error) {
                console.error(data.error);
                alert("API Key xxxz Invalida"); // Alertar si hay un error de API
                chatOutput.innerHTML += `<p><strong>Error:</strong> ${data.error}</p>`; // Mostrar error en el área de salida
            } else {
                // Mostrar la pregunta del usuario y la respuesta en el área de salida
                chatOutput.innerHTML += `<strong>${data.question}</strong><br>${data.response}<p></p>`;
                chatOutput.scrollTop = chatOutput.scrollHeight; // Desplazar hacia abajo para mostrar el nuevo mensaje
            }

            userInput.value = ''; // Limpiar el área de entrada
            sendButton.disabled = true; // Deshabilitar el botón de enviar nuevamente

        } catch (error) {
            console.error(error); // Mostrar error en consola
            chatOutput.innerHTML += `<p><strong>Error:</strong> ${error.message}</p>`; // Mostrar error en el área de salida
        } finally {
            loader.style.display = 'none'; // Ocultar el loader al finalizar
        }
    };

    // Evento para enviar el mensaje al presionar Enter
    userInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' && !event.shiftKey) { // Evitar enviar si Shift está presionado
            event.preventDefault(); // Prevenir el salto de línea
            if (!sendButton.disabled) sendButton.click(); // Enviar el mensaje si el botón no está deshabilitado
        }
    });

    // Habilitar o deshabilitar el botón de enviar según la entrada del usuario
    userInput.addEventListener('input', function () {
        sendButton.disabled = userInput.value.trim() === ''; // Deshabilitar si no hay texto
    });

    // Función para alternar la visibilidad del contenedor del chatbot al hacer clic en el botón
    openButton.onclick = function () {
        chatContainer.style.display = chatContainer.style.display === 'none' ? 'block' : 'none';
    };


    // Llamar a la función de validación de clave API al cargar el script
    validateApiKey();
})();