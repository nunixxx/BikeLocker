<?php
include_once '../Model/Funcionario.class.php';
require_once __DIR__ . "/../Utils/Message.php";
   
    if(isset($_POST['cpf']) && !empty($_POST['cpf']) && isset($_POST['senha']) && !empty($_POST['senha'])){

        require '../DataBase/Conexao.php';

        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];

        if(Funcionario::login($cpf, $senha) == true)
        {
            if($_SESSION['papel'] == 'func')
            {
                header('Location:../View/Func/Bicicletario.php');
            }else
            {
                header('Location:../View/Adm/Gere.Func.php');
            }
        
        }else{
            $message = new Message();
            $message->setTipo("danger");
            $message->setConteudo("Credenciais inválidas");

            header('Location:../View/Login.php?message=' . $message->__toString());
        }   

    }else{
        $message = new Message();
        $message->setTipo("danger");
        $message->setConteudo("Preencha os Dados!");

        header('Location:../View/Login.php?message=' . $message->__toString());
    }   
?>