<?php
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
        $this->cpf = $cpf;
    }
    public function getCor() 
    {
        return $this->cor;
    }
    public function setCor($cor)
    {
        $this->cor = $cor;
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
        $stmt->execute([
        ':cor' => $this->cor,
        ':CPF' => $this->cpf
        ]);
        $this->setId($pdo->lastInsertId());

        $pdo->commit();
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
        $stmt->execute([
            ':id' => $id
        ]); 
        $pdo->commit();
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

    $stmt->execute([
        ':cor' => $this->cor,
        ':id' => $this->id
    ]);
    return true;
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