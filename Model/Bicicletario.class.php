<?php
require_once __DIR__ .'/../Utils/autoload.php';

class Bicicletario{

        private $locker;
        private $cpf;
        private $cadeado;
        private $chegada;
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

            $stmt = $pdo->prepare('INSERT INTO bicicletario (LOCKER, usuario_CPF, CADEADO, CHEGADA, Bike_ID) VALUES (:locker, :cpf, :cadeado, :chegada, :bikeId)');
            $res = $stmt->execute([
            ':locker' => $this->locker,
            ':cpf' => $this->cpf,
            ':cadeado' => $this->cadeado,
            ':chegada' => $this->chegada,
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

            $stmt = $pdo->prepare('DELETE FROM Bicicletario WHERE LOCKER = :locker');
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
        foreach ($pdo->query("SELECT * FROM bicicletario") as $linha) {
            $bicicletario = new Bicicletario();
            $bicicletario->setlocker($linha["LOCKER"]);
            $bicicletario->setCpf($linha["usuario_CPF"]);
            $bicicletario->setCadeado($linha["CADEADO"]);
            $bicicletario->setChegada($linha["CHEGADA"]);
            $bicicletario->setBikeId($linha["Bike_ID"]);

            $lista[] = $bicicletario;
        }
        return $lista;
    }

    public static function loadByBike($id){
        $pdo = Conexao::conexao();
        try {
                
            $pdo->beginTransaction(); 

            $stmt = $pdo->prepare('SELECT * FROM bicicletario WHERE Bike_ID = :id');
            $res = $stmt->execute([
                ':id' => $id
            ]); 
            $pdo->commit();
            return $res;
        } catch (PDOException $e) 
        {
            $pdo->rollBack();
            throw $e;
        }
    }
    public function load(){
        $pdo = Conexao::conexao();
        #TODO ver que esse código cheira mal...
        foreach($pdo->query('SELECT * FROM bicicletario WHERE locker = ' . $this->locker) as $linha){
            $this->setlocker($linha["LOCKER"]);
            $this->setCpf($linha["usuario_CPF"]);
            $this->setCadeado($linha["CADEADO"]);
            $this->setChegada($linha["CHEGADA"]);
            $this->setBikeId($linha["Bike_ID"]);
            // $this->setId($linha['Id_Bike']);
            }

        return $this;
    }

    public function loadCheck(){
        $pdo = Conexao::conexao();

        try {

            $stmt = $pdo->prepare('SELECT * FROM bicicletario WHERE locker = :locker OR usuario_CPF = :cpf');
             $stmt->execute([
                ':locker' => $this->locker,
                ':cpf' => $this->cpf
            ]); 
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return count($res) > 0;
        } catch (PDOException $e) 
        {
            $pdo->rollBack();
            throw $e;
        }
    }

    public function __toString() {
        return "Locker: " . $this->locker . "<br>" .
               "CPF: " . $this->cpf . "<br>" .
               "Cadeado: " . $this->cadeado . "<br>" .
               "Chegada: " . $this->chegada . "<br>" .
               "Bike ID: " . $this->bikeId . "<br>";
    }

}