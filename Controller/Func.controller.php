<?php
$acao = $_GET['acao'];

require_once '../Utils/autoload.php';

//Cadastrar no banco
if ($acao == 'cadastrar'){
    
    $funcionario = new Funcionario();
    $funcionario->setCpf($_POST['cpf']);
    $funcionario->setNome($_POST['nome']);
    $funcionario->setEmail($_POST['email']);
    $funcionario->setSenha($_POST['senha']);
    $funcionario->setPapel($_POST['papel']);
    
    $funcionario->save();
    header('Location:../View/Adm/Gere.Func.php ');
}
else if($acao == 'deletar'){
    Funcionario::delete($_REQUEST['id']);
    header('Location:../View/Adm/Gere.Func.php ');
}
// } else if($acao =='atualizar'){
//     $funcionario = new Funcionario();
//     $funcionario->setCpf($_POST['cpf']);
//     $funcionario->setNome($_POST['nome']);
//     $funcionario->setEmail($_POST['email']);
//     $funcionario->setSenha($_POST['senha']);
//     $funcionario->setPapel($_POST['papel']);
    
//     $funcionario->update();

//     header('Location:../View/Adm/Gere.Func.php ');

// }

?>
