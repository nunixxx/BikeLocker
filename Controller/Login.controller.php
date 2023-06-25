<?php
include_once '../Model/Funcionario.class.php';
   
    if(isset($_POST['cpf']) && !empty($_POST['cpf']) && isset($_POST['senha']) && !empty($_POST['senha'])){

        require '../DataBase/Conexao.php';

        $func = new Funcionario();

        $cpf = addslashes($_POST['cpf']);
        $senha = addslashes($_POST['senha']);

        if($func->login($cpf, $senha) == true)
        {
            if($_SESSION['papel'] == 'func')
            {
                header('Location:../View/Func/Bicicletario.php');
            }else
            {
                header('Location:../View/Adm/Gere.Func.php');
            }

        }else{
            header('Location:../View/Login.php');
        }

    }else{
        header('Location:../View/Login.php');
    }
?>