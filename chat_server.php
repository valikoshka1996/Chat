<?php
use Workerman\Worker;
require_once __DIR__ . '/vendor/autoload.php';

// Create a Websocket server
$ws_worker = new Worker("websocket://0.0.0.0:2346");

// 4 processes
$ws_worker->count = 4;

// Array to store connections
$users = [];

// Emitted when new connection come
$ws_worker->onConnect = function($connection) use (&$users) {
    $connection->onWebSocketConnect = function($connection) use (&$users) {
        global $users;
        // Store the new connection
        $users[$connection->id] = $connection;
    };
};

// Emitted when data received
$ws_worker->onMessage = function($connection, $data) use (&$users) {
    $messageData = json_decode($data, true);
    
    // Check if the message is for setting a username
    if (isset($messageData['type']) && $messageData['type'] === 'set_username') {
        $connection->username = $messageData['username'];
        $connection->send(json_encode(['type' => 'welcome', 'message' => 'Welcome ' . $connection->username]));
        sendActiveUsers($users);
        return;
    }

    // Send the message to all connected clients
    foreach ($users as $user) {
        if (isset($connection->username)) {
            $user->send(json_encode(['type' => 'chat', 'username' => $connection->username, 'message' => $messageData['message']]));
        }
    }
};

// Emitted when connection closed
$ws_worker->onClose = function($connection) use (&$users) {
    unset($users[$connection->id]);
    sendActiveUsers($users);
};

// Function to send active users list
function sendActiveUsers($users) {
    $activeUsers = [];
    foreach ($users as $user) {
        if (isset($user->username)) {
            $activeUsers[] = ['username' => $user->username, 'status' => 'active'];
        }
    }
    $data = json_encode(['type' => 'active_users', 'users' => $activeUsers]);
    foreach ($users as $user) {
        $user->send($data);
    }
}

// Run worker
Worker::runAll();
?>
