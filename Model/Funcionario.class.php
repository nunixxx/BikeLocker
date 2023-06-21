<?php
 include_once "../DataBase/Conexao.php";
class Funcionario {
    private $cpf;
    private $nome;
    private $senha;
    private $papel;

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

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getPapel() {
        return $this->papel;
    }

    public function setPapel($papel) {
        $this->papel = $papel;
    }

    public function save(){
        $pdo = conexao();

        try {
            
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('INSERT INTO FUNCIONARIO (cpf, nome, senha, papel) VALUES (:cpf, :nome, :senha, :papel)');
            $stmt->execute([
                ':cpf' => $this->cpf,
                ':nome' => $this->nome,
                ':senha' => $this->senha,
                ':papel' => $this->papel
            ]);
            $pdo->commit();
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function delete($id){
        $pdo = conexao();

        $stmt = $pdo->prepare('DELETE FROM USUARIO WHERE id_user = :id');
        $stmt->execute([
            ':id' => $id
        ]); 
    }
    public static function getAll(){
        $pdo = conexao();
        $lista = [];
        foreach($pdo->query('SELECT * FROM USUARIO') as $linha){
            $user = new Usuario();
            $user->setNome($linha['nome']);
            $user->setEmail($linha['email']);
            $user->setSenha($linha['senha']);
            $user->setId($linha['id_user']);

            $lista[] = $user;
        }
    return $lista;
    }
    public function update(){
        $pdo = conexao();
        try{
        $stmt = $pdo->prepare('UPDATE USUARIO SET nome = :nome, email = :email, senha = :senha WHERE id = :id');

        $stmt->execute([
            ':nome' => $this->nome,
            ':senha' => $this->senha,
            ':email' => $this->email,
            ':id' => $this->id
        ]);
        return true;
        } catch (Exception $e){
            return false;
        }
    }
    public  function load(){
        $pdo = conexao();
        #TODO ver que esse código cheira mal...
        foreach($pdo->query('SELECT * FROM USUARIOS WHERE id = ' . $this->id) as $linha){
            $this->setNome($linha['nome']);
            $this->setEmail($linha['email']);
            $this->setSenha($linha['senha']);
            }

        return $this;
    }
}
?>