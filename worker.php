<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('178.170.13.229', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo 'Reception de la commande : ', $msg->body, "\n";
    sleep(5);
    $pdo = new PDO("mysql:host=localhost;dbname=apirest", 'root', '');
    $addToQueue = $pdo->prepare("UPDATE orders SET flag = 'Commande traitée' WHERE orders.uid = ?");
    $addToQueue->execute(array($msg->body));
    echo 'Commande traitée : ', $msg->body, "\n";
};

$channel->basic_consume('hello', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>