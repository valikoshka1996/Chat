<?php
use Workerman\Worker;
require_once __DIR__ . '/vendor/autoload.php';

// Create a Websocket server
$ws_worker = new Worker("websocket://0.0.0.0:2346");

// Store user connections
$users = [];

// When a client connects
$ws_worker->onConnect = function($connection) use (&$users) {
    $connection->onWebSocketConnect = function($connection) use (&$users) {
        $users[$connection->id] = [
            'connection' => $connection,
            'name' => '',
            'status' => 'active'
        ];
    };
};

// When a client sends a message
$ws_worker->onMessage = function($connection, $data) use (&$users) {
    $messageData = json_decode($data, true);
    
    if (isset($messageData['type']) && $messageData['type'] === 'setName') {
        $users[$connection->id]['name'] = $messageData['name'];
    } elseif (isset($messageData['type']) && $messageData['type'] === 'chat') {
        $name = $users[$connection->id]['name'];
        $message = $messageData['message'];
        
        foreach ($users as $user) {
            $user['connection']->send(json_encode([
                'type' => 'chat',
                'name' => $name,
                'message' => $message
            ]));
        }
    }
};

// When a client disconnects
$ws_worker->onClose = function($connection) use (&$users) {
    unset($users[$connection->id]);
};

// Run the server
Worker::runAll();
