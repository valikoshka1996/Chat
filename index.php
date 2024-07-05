<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чат</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .chat-container {
            margin-top: 50px;
        }
        .messages {
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #dee2e6;
            padding: 10px;
            background-color: #ffffff;
        }
        .message {
            margin-bottom: 10px;
        }
        .message .name {
            font-weight: bold;
        }
        .status {
            font-size: 0.9em;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container chat-container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div id="login" class="card">
                    <div class="card-body">
                        <h5 class="card-title">Введіть своє ім'я</h5>
                        <input type="text" id="nameInput" class="form-control" placeholder="Ваше ім'я">
                        <button id="enterChat" class="btn btn-primary btn-block mt-3">Увійти</button>
                    </div>
                </div>
                <div id="chat" class="card d-none">
                    <div class="card-body">
                        <div class="messages" id="messages"></div>
                        <div class="input-group mt-3">
                            <input type="text" id="messageInput" class="form-control" placeholder="Ваше повідомлення">
                            <div class="input-group-append">
                                <button id="sendMessage" class="btn btn-primary">Надіслати</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let ws;
        let userName = '';

        document.getElementById('enterChat').onclick = function() {
            enterChat();
        };

        document.getElementById('nameInput').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                enterChat();
            }
        });

        document.getElementById('sendMessage').onclick = function() {
            sendMessage();
        };

        document.getElementById('messageInput').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        });

        function enterChat() {
            userName = document.getElementById('nameInput').value;
            if (userName) {
                document.getElementById('login').classList.add('d-none');
                document.getElementById('chat').classList.remove('d-none');
                ws = new WebSocket('ws://localhost:2346');
                ws.onopen = function() {
                    ws.send(JSON.stringify({ type: 'setName', name: userName }));
                };
                ws.onmessage = function(event) {
                    const data = JSON.parse(event.data);
                    if (data.type === 'chat') {
                        const messageElement = document.createElement('div');
                        messageElement.classList.add('message');
                        messageElement.innerHTML = '<span class="name">' + data.name + '</span>: ' + data.message;
                        document.getElementById('messages').appendChild(messageElement);
                        document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
                    }
                };
            }
        }

        function sendMessage() {
            const message = document.getElementById('messageInput').value;
            if (message) {
                ws.send(JSON.stringify({ type: 'chat', message: message }));
                document.getElementById('messageInput').value = '';
            }
        }
    </script>
</body>
</html>
