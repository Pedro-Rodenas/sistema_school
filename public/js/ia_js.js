document.addEventListener('DOMContentLoaded', function () {
    // 1. Elementos del DOM
    const chatModal = document.getElementById('ai-chat-modal');
    const fabButton = document.getElementById('ai-chat-trigger');
    const closeButton = document.getElementById('close-chat-btn');
    const userInput = document.getElementById('user-input');
    const sendButton = document.getElementById('send-btn');
    const chatBody = document.getElementById('chat-body');

    // 2. Abrir/Cerrar Modal
    fabButton?.addEventListener('click', () => {
        chatModal?.classList.toggle('active');
        userInput?.focus();
    });

    closeButton?.addEventListener('click', () => {
        chatModal?.classList.remove('active');
    });

    // 3. Lógica de Mensajería y AJAX

    /**
     * Añade un mensaje al cuerpo del chat y desplaza el scroll.
     * @param {string} text - El contenido del mensaje.
     * @param {string} type - 'user' o 'system'.
     */
    function appendMessage(text, type) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message');
        messageDiv.classList.add(type + '-message');
        messageDiv.textContent = text;
        chatBody?.appendChild(messageDiv);
        // Desplazar al final del chat
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    /**
     * Envía la consulta al servidor de Laravel.
     */
    function sendMessage() {
        const message = userInput?.value.trim();
        if (message) {
            // Mostrar mensaje del usuario
            appendMessage(message, 'user');
            userInput.value = '';

            // Mostrar mensaje de carga mientras se espera la IA
            appendMessage("🤖 Buscando datos y generando respuesta...", 'system');

            // 🚨 LLAMADA AJAX A LARAVEL 🚨
            fetch('/api/ai/query', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // Obtiene el token CSRF del meta tag, esencial para Laravel
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ query: message })
            })
                .then(response => {
                    // Si la respuesta no es 200 OK, lanzamos un error
                    if (!response.ok) {
                        throw new Error('Server returned error: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    // Elimina el mensaje de "Buscando datos..."
                    const loadingMessage = chatBody?.querySelector('.system-message:last-child');
                    if (loadingMessage && loadingMessage.textContent.includes('Buscando datos')) {
                        loadingMessage.remove();
                    }

                    // Añade la respuesta final de la IA
                    appendMessage(data.response || "Lo siento, hubo un error al procesar la consulta.", 'system');
                })
                .catch(error => {
                    console.error('Error en la consulta AJAX:', error);

                    // Muestra un error más claro al usuario
                    const loadingMessage = chatBody?.querySelector('.system-message:last-child');
                    if (loadingMessage) {
                        loadingMessage.textContent = "❌ Error de conexión con el servidor IA. Inténtalo de nuevo.";
                    } else {
                        appendMessage("❌ Error de conexión con el servidor IA.", 'system');
                    }
                });
        }
    }

    // 4. Listeners para Enviar Mensaje
    sendButton?.addEventListener('click', sendMessage);

    userInput?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });
});