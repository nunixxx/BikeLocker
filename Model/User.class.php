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
            $res = $stmt->execute([
                ':cpf' => $this->cpf,
                ':nome' => $this->nome,
            ]);
            $pdo->commit();
            return $res;

        } catch (PDOException $e) {
            $pdo->rollBack();
            return "Erro ao salvar dados! ".$e->getCode(). ", ".($e::class);
        }
    }

    public static function delete($cpf)
    {
        global $pdo;

        $stmt = $pdo->prepare('DELETE FROM USUARIO WHERE CPF = :cpf');
        $res = $stmt->execute([
            ':cpf' => $cpf
        ]); 
        return $res;
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

        $res = $stmt->execute([
            ':nome' => $this->nome,
            ':cpf' => $this->cpf,
        ]);
        echo $res;

        return $res;
        } catch (Exception $e){
            return $e->getMessage();
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