<?php
require_once("./bddConnection.php");
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('178.170.13.229', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('ordersQueue', false, false, false, false);

echo " [*] En attente de message. Pour arretr le script, presser CTRL+C\n";

$callback = function ($msg) {
    echo 'Reception de la commande : ', $msg->body, "\n";
    //Possibilité de commenter le sleep pour avoir un traitement instantané de la queue;
    sleep(5);
    $pdo = getConnexion();
    $addToQueue = $pdo->prepare("UPDATE orders SET flag = 'Commande traitée' WHERE orders.uid = ?");
    $addToQueue->execute(array($msg->body));
    echo 'Commande traitée : ', $msg->body, "\n";
};

$channel->basic_consume('ordersQueue', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>