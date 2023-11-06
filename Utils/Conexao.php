<?php
class Conexao{
    static function conexao(){
    
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        global $pdo;
        
        try {
            $pdo = new PDO(
                "mysql:host=bikelocker.mysql.dbaas.com.br;dbname=bikelocker;charset=utf8",
                "bikelocker",
                "Claro@16102004"
            );
        
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            return $pdo;
        } catch (PDOException $e) {
            echo "ERRO DE CONEXÃO: " . $e::class . " " . $e->getMessage();
        }
    }
    
}

?>