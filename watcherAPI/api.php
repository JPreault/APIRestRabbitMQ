<?php 

function getOrderInfo($data){
  $uid = $data['uid'] ?? null;

  if(!is_string($uid)) {
    throw new Exception ("Incorrect data");
  }

  try {
    $pdo = getConnexion();
    $getorder = $pdo->prepare("SELECT o.uid, o.object, o.address, o.flag, o.date FROM orders AS o WHERE o.uid = ?");
    $getorder->execute(array($uid));
    $order = $getorder->fetchAll(PDO::FETCH_ASSOC);
    sendJSON($order);
  }
  catch( PDOException $Exception ) {
    throw new Exception ("Error with the database connexion");
  }
}

function listOrder(){
  try {
    $pdo = getConnexion();
    $getorder = $pdo->prepare("SELECT o.uid, o.object, o.address, o.flag, o.date FROM orders AS o ");
    $getorder->execute();
    $order = $getorder->fetchAll(PDO::FETCH_ASSOC);
    sendJSON($order);
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