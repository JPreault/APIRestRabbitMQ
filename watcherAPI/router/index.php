<?php
require_once("../api.php");
try{
    if(!empty($_GET['route'])){
        $url = explode("/", filter_var($_GET['route'],FILTER_SANITIZE_URL));
        switch($url[0]){
            case "getOrderInfo" :
                if(!empty($_GET['uid'])){
                  getOrderInfo($_GET);
                }else{
                    throw new Exception ("Data is missing");
                }
            break;
            case "listOrder" :
                listOrder();
            break;
            default : throw new Exception ("This URL does not exist");
        }
    } else {
        throw new Exception ("Error in the data recovery");
    }
} catch(Exception $e){
    $erreur = [
        "error" => $e->getMessage(),
    ];
    sendJSON($erreur);
}
