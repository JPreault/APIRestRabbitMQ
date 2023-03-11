<?php
function getConnexion(){
  $host = 'localhost';
  $dbname = 'apirest';
  $user = 'root';
  $password = '';
  return new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
}