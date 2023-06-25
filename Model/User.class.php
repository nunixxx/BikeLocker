<?php
 require __DIR__ . "..\..\DataBase\Conexao.php";

class Usuario {
    private $cpf;
    private $nome;

    public function getCPF() {
        return $this->cpf;
    }

    public function setCPF($cpf) {
        $this->cpf = $cpf;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function save()
    {
        global $pdo;

        try {
            
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('INSERT INTO USUARIO (cpf, nome) VALUES (:cpf, :nome)');
            $stmt->execute([
                ':cpf' => $this->cpf,
                ':nome' => $this->nome,
            ]);
            $pdo->commit();
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function delete($cpf)
    {
        global $pdo;

        $stmt = $pdo->prepare('DELETE FROM USUARIO WHERE CPF = :cpf');
        $stmt->execute([
            ':cpf' => $cpf
        ]); 
    }
    public static function getAll()
    {
        global $pdo;
        $lista = [];
        foreach($pdo->query('SELECT * FROM USUARIO') as $linha){
            $user = new Usuario();
            $user->setNome($linha['NOME']);
            $user->setCPF($linha['CPF']);

            $lista[] = $user;
        }
    return $lista;
    }
    public function update()
    {
        global $pdo;
        try{
        $stmt = $pdo->prepare('UPDATE Usuario SET nome = :nome WHERE cpf = :cpf');

        $stmt->execute([
            ':nome' => $this->nome,
            ':cpf' => $this->cpf,
        ]);
        $pdo->commit();
        return true;
        } catch (Exception $e){
            return false;
        }
    }
    public  function load()
    {
        global $pdo;
        #TODO ver que esse código cheira mal...
        foreach($pdo->query('SELECT * FROM Usuario WHERE CPF = ' . $this->cpf) as $linha){
            $this->setNome($linha['NOME']);
            }

        return $this;
    }

public function __toString()
    {
        return $this->getNome() ." // ". $this->getCPF();
    }
}