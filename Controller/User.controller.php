<?php
$acao = $_GET['acao'];
echo $acao;
include_once '../Model/User.class.php';

//Cadastrar no banco
if ($acao == 'cadastrar'){
    $user = new Usuario();
    $user->setCpf($_POST['cpf']);
    $user->setNome($_POST['nome']);
    echo $acao;
    $user->save();
    header('Location:../View/Func/Gere.User.php');
}
else if($acao == 'deletar'){
    Usuario::delete($_REQUEST['id']);
    header('Location:../View/Func/Gere.User.php');
} else if($acao == 'atualizar'){
    $user = new Usuario();
    $user->setCPF($_POST['cpf']);
    $user->setNome($_POST['nome']);

    $user->update();

    header('Location:../View/Func/Gere.User.php');

}
?>