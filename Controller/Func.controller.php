<?php
require_once '../Utils/autoload.php';

session_start();

$session_timeout= 1800;

if(time() - $_SESSION['loggedin'] < $session_timeout){
    $acao = $_GET['acao'];
 
    include_once '../Model/Funcionario.class.php';
    
    //Cadastrar no banco
    if ($acao == 'cadastrar'){
        
        $funcionario = new Funcionario();
        $res = $funcionario->setCpf($_POST['cpf']);
        if($res){
            $var = $funcionario->setSenha($_POST['senha']);
            if($var){
            $funcionario->setNome($_POST['nome']);
            $funcionario->setEmail($_POST['email']);
            $funcionario->setPapel($_POST['papel']);
            
            $funcionario->save();
            header('Location:../View/Adm/Gere.Func.php ');
            }else{
                $message = new Message();
                $message->setTipo("danger");
                $message->setConteudo("A senha deve conter no minimo 4 caractéres");

                header('Location:../View/Adm/Gere.Func.php?message=' . $message->__toString());
            }
        }else{
            $message = new Message();
            $message->setTipo("danger");
            $message->setConteudo("CPF inválido");

            header('Location:../View/Adm/Gere.Func.php?message=' . $message->__toString());
        }
    }
    else if($acao == 'deletar'){
        Funcionario::delete($_REQUEST['id']);
        header('Location:../View/Adm/Gere.Func.php ');
    }
}else{

    $message = new Message();
    $message->setTipo("danger");
    $message->setConteudo("Sessão expirada!");

    header('Location:../View/Login.php?message=' . $message->__toString());
}

?>
