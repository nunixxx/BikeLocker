<?php
require_once __DIR__ .'/../Utils/autoload.php';

class User
{
    private $cpf;
    private $nome;

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($cpf)
    {
        if (Validador::validarCpf($cpf) == true) {
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

    public function save()
    {
        $pdo = Conexao::conexao();

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare(
                "INSERT INTO usuario (cpf, nome) VALUES (:cpf, :nome)"
            );
            $res = $stmt->execute([
                ":cpf" => $this->cpf,
                ":nome" => $this->nome,
            ]);
            $pdo->commit();
            return $res;
        } catch (PDOException $e) {
            $pdo->rollBack();
            return "Erro ao salvar dados! " . $e->getCode() . ", " . $e::class;
        }
    }

    public static function delete($cpf)
    {
        $pdo = Conexao::conexao();

        $stmt = $pdo->prepare("DELETE FROM usuario WHERE CPF = :cpf");
        $res = $stmt->execute([
            ":cpf" => $cpf,
        ]);
        return $res;
    }
    public static function getAll()
    {
        $pdo = Conexao::conexao();
        $lista = [];
        foreach ($pdo->query("SELECT * FROM usuario") as $linha) {
            $user = new User();
            $user->setNome($linha["NOME"]);
            $user->setCpf($linha["CPF"]);

            $lista[] = $user;
        }
        return $lista;
    }
    public function update()
    {
        $pdo = Conexao::conexao();
        try {
            $stmt = $pdo->prepare(
                "UPDATE usuario SET nome = :nome WHERE cpf = :cpf"
            );

            $res = $stmt->execute([
                ":nome" => $this->nome,
                ":cpf" => $this->cpf,
            ]);
            echo $res;

            return $res;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function load()
    {
        $pdo = Conexao::conexao();
        #TODO ver que esse código cheira mal...
        foreach (
            $pdo->query("SELECT * FROM usuario WHERE CPF = " . $this->cpf)
            as $linha
        ) {
            $this->setNome($linha["NOME"]);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNome() . " // " . $this->getCpf();
    }
}