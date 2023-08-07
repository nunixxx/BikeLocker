<?php
require __DIR__ . "..\..\DataBase\Conexao.php";
include_once __DIR__ . "..\..\/Utils/ValidarDados.php";

class Bike {
    private $cor;
    private $id;
    private $cpf;

    public function getCpf() 
    {
        return $this->cpf;
    }
    public function setCpf($cpf)
    {
        if(validarCpf($cpf) == true){
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
        if(validarCor($cor) == true){
            $this->cor = $cor;
            return true;
        }else{
            return false;
        }
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
    global $pdo;
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

public static function delete($id)
{
    global $pdo;
    try {
            
        $pdo->beginTransaction(); 

        $stmt = $pdo->prepare('DELETE FROM BIKE WHERE CPF = :id');
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
    global $pdo;
    $lista = [];
    try{

        $pdo->beginTransaction();

        foreach($pdo->query('SELECT * FROM BIKE') as $linha){
            $bike = new Bike();
            $bike->setCor($linha['cor']);
            $bike->setId($linha['Id_Bike']);
            $bike->setCpf($linha['cpf']);

            $pdo->commit();
            $lista[] = $bike;
        }
    } catch (PDOException $e) 
    {
        $pdo->rollBack();
        throw $e;
    } 
return $lista;
}

public function update()
{
    global $pdo;
    try{
        
    $stmt = $pdo->prepare('UPDATE BIKE SET cor = :cor WHERE id_bike = :id');

    $res = $stmt->execute([
        ':cor' => $this->cor,
        ':id' => $this->id
    ]);
    return $res;
        } catch (Exception $e){
            return false;
        }
    }
    
    public  function load(){
        global $pdo;
        #TODO ver que esse código cheira mal...
        foreach($pdo->query('SELECT * FROM bike WHERE cpf = ' . $this->cpf) as $linha){
            $this->setCor($linha['cor']);
            $this->setId($linha['Id_Bike']);
            }

        return $this;
    }

}
?>