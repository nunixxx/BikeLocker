<?php
$acao = $_GET['acao'];

include_once '../model/Funcionario.class.php';

//Cadastrar no banco
if ($acao == 'cadastrar'){
    $funcionario = new Funcionario();
    $funcionario->setCpf($_POST['cpf']);
    $funcionario->setNome($_POST['nome']);
    $funcionario->setSenha($_POST['senha']);
    $funcionario->setPapel($_POST['papel']);
    
    $funcionario->save();
    header('Location:../View/Index.php ');
}
else if($acao == 'deletar'){
    funcionario::delete($_REQUEST['cpf']);
    header('Location:../View/Index.php ');

} else if($acao =='atualizar'){
    $funcionario = new Funcionario();
    $funcionario->setNome($_POST['nome']);
    $funcionario->setEmail($_POST['email']);
    $funcionario->setSenha($_POST['senha']);
    $funcionario->setPapel($_POST['papel']);
    
    $funcionario->update();

    header('Location:../View/Index.php ');

}

?>
