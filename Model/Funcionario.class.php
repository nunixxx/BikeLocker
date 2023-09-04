<?php
require __DIR__ . "..\..\DataBase\Conexao.php";
include_once __DIR__ . "..\..\/Utils/ValidarDados.php";

class Funcionario
{
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
        if (validarEmail($email) == true) {
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }
    public function getCPF()
    {
        return $this->cpf;
    }

    public function setCPF($cpf)
    {
        if (validarCpf($cpf) == true) {
            $this->cpf = $cpf;
            return true;
        } else {
            return false;
        }
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
        $boo = validarSenha($senha);
        if ($boo == true) {
            if(password_needs_rehash($senha, PASSWORD_DEFAULT)){
                $this->senha =  password_hash($senha, PASSWORD_DEFAULT);
            } else {
                $this->senha = $senha;
            }
        
        return true;    
        } else {
            return false;
        }
    }

    public function getPapel()
    {
        return $this->papel;
    }

    public function setPapel($papel)
    {
        $this->papel = $papel;
    }

    public static function login($cpf, $senha)
    {
        global $pdo;

        $stmt = $pdo->prepare(
            "SELECT * FROM funcionario WHERE CPF = :cpf"
        );
        $stmt->execute([
            ":cpf" => $cpf,
        ]);

        if ($stmt->rowCount() == 1 ) {
            $dado = $stmt->fetch();
            if(password_verify($senha, $dado["senha"])){
                $_SESSION["cpfFunc"] = $dado["CPF"];
                $_SESSION["papel"] = $dado["papel"];
                return true;
            }            
            return false;
        } else {
            return false;
        }
    }

    public function save()
    {
        global $pdo;

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare(
                "INSERT INTO FUNCIONARIO (cpf, nome, senha, papel, email) VALUES (:cpf, :nome, :senha, :papel, :email)"
            );
            $res = $stmt->execute([
                ":cpf" => $this->cpf,
                ":nome" => $this->nome,
                ":senha" => $this->senha,
                ":papel" => $this->papel,
                ":email" => $this->email,
            ]);
            $pdo->commit();
            return $res;
        } catch (PDOException $e) {
            $pdo->rollBack();
            return $e->getMessage();
        }
    }

    public static function delete($cpf)
    {
        global $pdo;

        $stmt = $pdo->prepare("DELETE FROM FUNCIONARIO WHERE CPF = :cpf");
        $res = $stmt->execute([
            ":cpf" => $cpf,
        ]);
        return $res;
    }
    public static function getAll()
    {
        global $pdo;
        $lista = [];
        foreach ($pdo->query("SELECT * FROM FUNCIONARIO") as $linha) {
            $funcs = new Funcionario();
            $funcs->setNome($linha["nome"]);
            $funcs->setSenha($linha["senha"]);
            $funcs->setCPF($linha["CPF"]);
            $funcs->setPapel($linha["papel"]);
            $funcs->setEmail($linha["email"]);

            $lista[] = $funcs;
        }
        return $lista;
    }
    public function update()
    {
        global $pdo;
        try {
            $stmt = $pdo->prepare(
                "UPDATE FUNCIONARIO SET nome = :nome, papel = :papel, senha = :senha, email = :email WHERE cpf = :cpf"
            );

            $res = $stmt->execute([
                ":nome" => $this->nome,
                ":senha" => $this->senha,
                ":papel" => $this->papel,
                ":cpf" => $this->cpf,
                ":email" => $this->email,
            ]);
            return $res;
        } catch (Exception $e) {
            return false;
        }
    }
    public function load()
    {
        global $pdo;
        #TODO ver que esse código cheira mal...
        foreach (
            $pdo->query("SELECT * FROM FUNCIONARIO WHERE CPF = " . $this->cpf)
            as $linha
        ) {
            $this->setNome($linha["nome"]);
            $this->setPapel($linha["papel"]);
            $this->setSenha($linha["senha"]);
            $this->setEmail($linha["email"]);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNome() .
            " // " .
            $this->getEmail() .
            " // " .
            $this->getPapel();
    }
}
?>