<?php
$acao = $_GET['acao'];

$imageName = $_POST['cpf'];
$savePath = '../Arquivos/'.$imageName;
$imagePath = $_FILES['imagem']['tmp_name'];

include_once '../Model/User.class.php';

if ($acao == 'cadastrar'){
    $user = new Usuario();
    $user->setCpf($_POST['cpf']);
    $user->setNome($_POST['nome']);


    move_uploaded_file($imagePath,$savePath);

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

    move_uploaded_file($imagePath,$savePath);

    $user->update();

    header('Location:../View/Func/Gere.User.php');

}
?>