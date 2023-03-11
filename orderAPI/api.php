<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

function createOrder($data) {
  $object = $data['object'] ?? null;
  $address = $data['address'] ?? null;

  if(!is_string($object) || !is_string($address)) {
    throw new Exception ("Incorrect data");
  }
  $uid = uniqid("order");

  try {
    $pdo = getConnexion();
    $insertorder = $pdo->prepare("INSERT INTO orders(uid, object, address, flag) VALUES(?, ?, ?, ?)");
    $insertorder->execute(array($uid, $object, $address, 'Commande en cours de traitement'));

    $connection = new AMQPStreamConnection('178.170.13.229', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('ordersQueue', false, false, false, false);

    $msg = new AMQPMessage($uid);
    $channel->basic_publish($msg, '', 'ordersQueue');
    $channel->close();
    $connection->close();

    sendJSON("Voici votre ID de commande : ".$uid);

  }
  catch( PDOException $Exception ) {
    throw new Exception ("Error with the database connexion");
  }
}

function sendJSON($infos){
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    echo json_encode($infos,JSON_UNESCAPED_UNICODE);
}