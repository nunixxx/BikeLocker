<?php
require_once '../Utils/autoload.php';

if(time() - $_SESSION['loggedin'] < $session_timeout){
    $acao = $_GET['acao'];


    include_once '../Model/Funcionario.class.php';
    
    //Cadastrar no banco
    if ($acao == 'cadastrar'){
        
        $funcionario = new Funcionario();
        $funcionario->setCpf($_POST['cpf']);
        $funcionario->setNome($_POST['nome']);
        $funcionario->setEmail($_POST['email']);
        $funcionario->setSenha($_POST['senha']);
        $funcionario->setPapel($_POST['papel']);
        
        $funcionario->save();
        header('Location:../public_html/Adm/Gere.Func.php ');
    }
    else if($acao == 'deletar'){
        Funcionario::delete($_REQUEST['id']);
        header('Location:../public_html/Adm/Gere.Func.php ');
    }
}else{

    $message = new Message();
    $message->setTipo("danger");
    $message->setConteudo("Sessão expirada!");

    header('Location:../public_html/Login.php?message=' . $message->__toString());
}

// } else if($acao =='atualizar'){
//     $funcionario = new Funcionario();
//     $funcionario->setCpf($_POST['cpf']);
//     $funcionario->setNome($_POST['nome']);
//     $funcionario->setEmail($_POST['email']);
//     $funcionario->setSenha($_POST['senha']);
//     $funcionario->setPapel($_POST['papel']);
    
//     $funcionario->update();

//     header('Location:../public_html/Adm/Gere.Func.php ');

// }

?>
