<?php
// session_start();
if ( session_status() !== PHP_SESSION_ACTIVE )
 {
    session_start();
}
global $pdo;

try {
    $pdo = new PDO('mysql:host=localhost;dbname=bikelocker;charset=utf8', 'root','');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;    
}
catch (PDOException $e) {
    echo 'ERRO DE CONEXÃO: '.($e::class)." ".$e->getMessage();
}
?>
