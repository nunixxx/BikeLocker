<?php
require_once __DIR__ .'/../Utils/autoload.php';

class Bike {
    private $cor;
    private $id;
    private $cpf;
    private $data;
    private $bike_id;

    public function getCpf() 
    {
        return $this->cpf;
    }
    public function setCpf($cpf)
    {
        if(Validador::validarCpf($cpf) == true){
            $this->cpf = $cpf;
            return true;
        }else{
            return false;
        } 
    }
    public function getCor() 
    {
        return $this->cor;
    }
    public function setCor($cor)
    {
        $this->cor = $cor;
        // if(Validador::validarCor($cor) == true){
        //     $this->cor = $cor;
        //     return true;
        // }else{
        //     return false;
        // }
    }
    public function getId() 
    {
        return $this->id;
    }
    public function setId($id) 
    {
        $this->id = $id;
    }

public function save()
{        
    $pdo = Conexao::conexao();
    try {
            
        $pdo->beginTransaction();

        $stmt = $pdo->prepare('INSERT INTO Bike (cor, CPF) VALUES (:cor, :CPF)');
        $res = $stmt->execute([
        ':cor' => $this->cor,
        ':CPF' => $this->cpf
        ]);
        $this->setId($pdo->lastInsertId());

        $pdo->commit();

        return $res;
        } catch (PDOException $e) 
        {
            $pdo->rollBack();
            throw $e;
        }
}

public static function deleteUser($id)
{
    $pdo = Conexao::conexao();
    try {
            
        $pdo->beginTransaction(); 

        $stmt = $pdo->prepare('DELETE FROM BIKE WHERE cpf = :id');
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

public static function delete($id)
{
    $pdo = Conexao::conexao();
    try {
            
        $pdo->beginTransaction(); 

        $stmt = $pdo->prepare('DELETE FROM BIKE WHERE Id_Bike = :id');
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
public static function getAll()
{
    $pdo = Conexao::conexao();
    $lista = [];
    foreach ($pdo->query("SELECT * FROM bike") as $linha) {
        $bike = new Bike();
        $bike->setId($linha["Id_Bike"]);
        $bike->setCor($linha["cor"]);
        $bike->setCpf($linha["cpf"]);

        $lista[] = $bike;
    }
    return $lista;
}

    public function update()
    {
        $pdo = Conexao::conexao();
        try{
            $stmt = $pdo->prepare(
                'UPDATE BIKE SET cor = :cor WHERE id_bike = :id'
            );

            $res = $stmt->execute([
                ':cor' => $this->cor,
                ':id' => $this->id
            ]);
            echo $res;
            return $res;
        } catch (Exception $e){
            throw $e;
            return false;
        }
    }
    
    public  function load(){
        $pdo = Conexao::conexao();
        #TODO ver que esse código cheira mal...
        foreach($pdo->query('SELECT * FROM bike WHERE Id_Bike = ' . $this->id) as $linha){
            $this->setCor($linha['cor']);
            $this->setCpf($linha['cpf']);
            }

        return $this;
    }

    public static function loadByCpf($cpf){
        $pdo = Conexao::conexao();
        $lista = [];
        foreach ($pdo->query("SELECT * FROM bike WHERE cpf = $cpf") as $linha) {
            $bike = new Bike();
            $bike->setId($linha["Id_Bike"]);
            $bike->setCor($linha["cor"]);
            $bike->setCpf($linha["cpf"]);

            $lista[] = $bike;
        }
        return $lista;
    }
}
?>