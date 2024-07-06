<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #chat-window {
            height: 400px;
            overflow-y: scroll;
            margin-bottom: 20px;
        }
        .message {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
        .status {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Chat Application</h1>
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="login-section" class="text-center">
                            <input type="text" id="username" class="form-control" placeholder="Enter your name" autofocus>
                            <button id="login-btn" class="btn btn-primary mt-3">Login</button>
                        </div>
                        <div id="chat-section" style="display: none;">
                            <div class="d-flex justify-content-between">
                                <span>Logged in as: <strong id="current-user"></strong></span>
                                <span id="server-status" class="status"></span>
                            </div>
                            <div id="chat-window" class="border rounded p-3 mt-3"></div>
                            <input type="text" id="message-input" class="form-control" placeholder="Type your message here">
                            <button id="send-btn" class="btn btn-primary mt-3">Send</button>
                            <button id="show-users-btn" class="btn btn-secondary mt-3">Show All Users</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for active users -->
    <div class="modal fade" id="activeUsersModal" tabindex="-1" aria-labelledby="activeUsersModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activeUsersModalLabel">Active Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="active-users-list">
                    <!-- List of active users will be shown here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const socket = new WebSocket('ws://localhost:2346');
        const loginSection = document.getElementById('login-section');
        const chatSection = document.getElementById('chat-section');
        const usernameInput = document.getElementById('username');
        const currentUser = document.getElementById('current-user');
        const serverStatus = document.getElementById('server-status');
        const chatWindow = document.getElementById('chat-window');
        const messageInput = document.getElementById('message-input');
        const showUsersBtn = document.getElementById('show-users-btn');
        const activeUsersList = document.getElementById('active-users-list');

        socket.onopen = function() {
            serverStatus.textContent = 'Server status: Active';
        };

        socket.onclose = function() {
            serverStatus.textContent = 'Server status: Inactive';
        };

        socket.onmessage = function(event) {
            const data = JSON.parse(event.data);
            if (data.type === 'chat') {
                const messageElement = document.createElement('div');
                messageElement.className = 'message';
                messageElement.textContent = `${data.username}: ${data.message}`;
                chatWindow.appendChild(messageElement);
                chatWindow.scrollTop = chatWindow.scrollHeight;
            } else if (data.type === 'welcome') {
                alert(data.message);
            } else if (data.type === 'active_users') {
                activeUsersList.innerHTML = '';
                data.users.forEach(user => {
                    const userElement = document.createElement('div');
                    userElement.textContent = `${user.username} - ${user.status}`;
                    activeUsersList.appendChild(userElement);
                });
            }
        };

        document.getElementById('login-btn').addEventListener('click', function() {
            const username = usernameInput.value.trim();
            if (username) {
                socket.send(JSON.stringify({ type: 'set_username', username: username }));
                currentUser.textContent = username;
                loginSection.style.display = 'none';
                chatSection.style.display = 'block';
                messageInput.focus();
            }
        });

        usernameInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                document.getElementById('login-btn').click();
            }
        });

        document.getElementById('send-btn').addEventListener('click', function() {
            const message = messageInput.value.trim();
            if (message) {
                socket.send(JSON.stringify({ message: message }));
                messageInput.value = '';
                messageInput.focus();
            }
        });

        messageInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                document.getElementById('send-btn').click();
            }
        });

        showUsersBtn.addEventListener('click', function() {
            const activeUsersModal = new bootstrap.Modal(document.getElementById('activeUsersModal'));
            activeUsersModal.show();
        });
    </script>
</body>
</html>
