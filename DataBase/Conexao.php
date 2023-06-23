<?php
session_start();

function Conexao(){

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=bikelocker;charset=utf8', 'root','');

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;    
    }
    catch (PDOException $e) {
        echo 'Erro de Banco' . $e->getMassege();
    }
}
?>
