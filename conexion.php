<?php
$servidor="mysql:dbname=tareas;host=localhost";
$usuario="root";
$password="sleeppartypeople";

try{
    $pdo=new PDO($servidor,$usuario,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
   // echo "conectado";
}
catch(PDOException $e){
  echo "error de conexion a base de datos".$e->getMessage();
 }
?>


