<?php
 include_once "../DataBase/Conexao.php";
class Funcionario {
    private $cpf;
    private $nome;
    private $senha;
    private $email;
    private $papel;

    public function getEmail() 
    {
        return $this->email;
    }

    public function setEmail($email) 
    {
        $this->email = $email;
    }
    public function getCPF() 
    {
        return $this->cpf;
    }

    public function setCPF($cpf) 
    {
        $this->cpf = $cpf;
    }

    public function getNome() 
    {
        return $this->nome;
    }

    public function setNome($nome) 
    {
        $this->nome = $nome;
    }

    public function getSenha() 
    {
        return $this->senha;
    }

    public function setSenha($senha) 
    {
        $this->senha = $senha;
    }

    public function getPapel() 
    {
        return $this->papel;
    }

    public function setPapel($papel) 
    {
        $this->papel = $papel;
    }

    public function login($cpf, $senha)
    {
        $pdo = conexao();

        $stmt= $pdo->prepare("SELECT * FROM funcionario WHERE CPF = :cpf AND senha = :senha");
        $stmt->execute([
            ':cpf' => $cpf,
            ':senha' => $senha,
        ]);

            if($stmt->rowCount() == 1){
                $dado = $stmt->fetch();

                $_SESSION['cpfFunc'] = $dado['cpf'];
                $_SESSION['papel']= $dado['papel'];

                return true;
            }else{
                return false;
            }

    }

    public function save()
    {
        $pdo = conexao();

        try {
            
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('INSERT INTO FUNCIONARIO (cpf, nome, senha, papel, email) VALUES (:cpf, :nome, :senha, :papel, :email)');
            $stmt->execute([
                ':cpf' => $this->cpf,
                ':nome' => $this->nome,
                ':senha' => $this->senha,
                ':papel' => $this->papel,
                ':email' => $this->email
            ]);
            $pdo->commit();
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function delete($cpf)
    {
        $pdo = conexao();

        $stmt = $pdo->prepare('DELETE FROM FUNCIONARIO WHERE CPF = :cpf');
        $stmt->execute([
            ':cpf' => $cpf
        ]); 
    }
    public static function getAll()
    {
        $pdo = conexao();
        $lista = [];
        foreach($pdo->query('SELECT * FROM FUNCIONARIO') as $linha){
            $funcs = new Funcionario();
            $funcs->setNome($linha['nome']);
            $funcs->setSenha($linha['senha']);
            $funcs->setCPF($linha['CPF']);
            $funcs->setPapel($linha['papel']);
            $funcs->setEmail($linha['email']);

            $lista[] = $funcs;
        }
    return $lista;
    }
    public function update()
    {
        $pdo = conexao();
        try{
        $stmt = $pdo->prepare('UPDATE FUNCIONARIO SET nome = :nome, papel = :papel, senha = :senha, email = :email WHERE cpf = :cpf');

        $stmt->execute([
            ':nome' => $this->nome,
            ':senha' => $this->senha,
            ':papel' => $this->papel,
            ':cpf' => $this->cpf,
            ':email' => $this->email
        ]);
        return true;
        } catch (Exception $e){
            return false;
        }
    }
    public  function load()
    {
        $pdo = conexao();
        #TODO ver que esse código cheira mal...
        foreach($pdo->query('SELECT * FROM FUNCIONARIO WHERE CPF = ' . $this->cpf) as $linha){
            $this->setNome($linha['nome']);
            $this->setPapel($linha['papel']);
            $this->setSenha($linha['senha']);
            }

        return $this;
    }

public function __toString()
    {
        return $this->getNome() ." // ". $this->getEmail() ." // ". $this->getPapel();
    }
}
?>