<?php
require_once __DIR__ .'/../Utils/autoload.php';

class Historico{

        private $locker;
        private $cpf;
        private $cadeado;
        private $chegada;
        private $saida;
        private $bikeId;
    
    public function getLocker() {
        return $this->locker;
    }

    public function setLocker($locker) {
        $this->locker = $locker; 
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function getCadeado() {
        return $this->cadeado;
    }

    public function setCadeado($cadeado) {
        $this->cadeado = $cadeado;
    }

    public function getChegada() {
        return $this->chegada;
    }

    public function setChegada($chegada) {
        $this->chegada = $chegada;
    }

    public function getSaida() {
        return $this->saida;
    }

    public function setSaida($saida) {
        $this->saida = $saida; 
    }

    public function getBikeId() {
        return $this->bikeId;
    }

    public function setBikeId($bikeId) {
        $this->bikeId = $bikeId; 
    }

    public function save()
    {        
        $pdo = Conexao::conexao();
        try {
                
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('INSERT INTO historico (LOCKER, usuario_CPF, CADEADO, CHEGADA, SAIDA, BIKE_ID)
            VALUES (:locker, :cpf, :cadeado, :chegada, :saida, :bikeId)');
            $res = $stmt->execute([
            ':locker' => $this->locker,
            ':cpf' => $this->cpf,
            ':cadeado' => $this->cadeado,
            ':chegada' => $this->chegada,
            ':saida' => $this->saida,    
            ':bikeId' => $this->bikeId
            ]);

            $pdo->commit();

            return $res;
            } catch (PDOException $e) 
            {
                $pdo->rollBack();
                throw $e;
            }
    }

    public static function delete($locker)
    {
        $pdo = Conexao::conexao();
        try {
                
            $pdo->beginTransaction(); 

            $stmt = $pdo->prepare('DELETE FROM historico WHERE LOCKER = :locker');
            $res = $stmt->execute([
                ':locker' => $locker
            ]); 
            $pdo->commit();
            return $res;
        } catch (PDOException $e) 
        {
            $pdo->rollBack();
            throw $e;
        }    
    }
    public static function getAll()
    {
        $pdo = Conexao::conexao();
        $lista = [];
        foreach ($pdo->query("SELECT * FROM historico") as $linha) {
            $historico = new historico();
            $historico->setlocker($linha["LOCKER"]);
            $historico->setCpf($linha["usuario_CPF"]);
            $historico->setCadeado($linha["CADEADO"]);
            $historico->setChegada($linha["CHEGADA"]);
            $historico->setBikeId($linha["Bike_ID"]);

            $lista[] = $historico;
        }
        return $lista;
    }

}