<?php
require_once '../Utils/autoload.php';
   
    if(isset($_POST['cpf']) && !empty($_POST['cpf']) && isset($_POST['senha']) && !empty($_POST['senha'])){

        Conexao::conexao();
        
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $_SESSION['loggedin'] = time();

        if(Funcionario::login($cpf, $senha) == true)
        {
            if($_SESSION['papel'] == 'func')
            {
                header('Location:../public_html/Func/Bicicletario.php');
            }else
            {
                header('Location:../public_html/Adm/Gere.Func.php');
            }
        
        }else{
            $message = new Message();
            $message->setTipo("danger");
            $message->setConteudo("Credenciais inválidas");

            header('Location:../public_html/Login.php?message=' . $message->__toString());
        }   

    }else{
        $message = new Message();
        $message->setTipo("danger");
        $message->setConteudo("Preencha os Dados!");

        header('Location:../public_html/Login.php?message=' . $message->__toString());
    }   
?>