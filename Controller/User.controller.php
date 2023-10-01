<?php
require_once __DIR__ .'/../Utils/autoload.php';
include_once __DIR__ . '/../Model/User.class.php';

$acao = $_GET['acao'];

$cor = $_POST['cor'];


if ($acao == 'cadastrar'){
    $user = new User();
    $user->setCpf($_POST['cpf']);
    $user->setNome($_POST['nome']);
    
    $user->save();

    $bike = new Bike();
    $bike->setCor($_POST['cor']);
    $bike->setCpf($user->getCpf());
    $bike->save();

    $imageName = $bike->getId();

    $savePath = '../Arquivos/'.$imageName.'.png';
    $imagePath = $_FILES['imagem']['tmp_name'];

    move_uploaded_file($imagePath,$savePath);
    header('Location:../View/Func/Gere.User.php');
}

else if($acao == 'deletar'){
    Bike::delete($_REQUEST['id']);
    User::delete($_REQUEST['id']);    
    header('Location:../View/Func/Gere.User.php');
    
} else if($acao == 'atualizar'){
    $user = new User();
    $user->setCpf($_POST['cpf']);
    $user->setNome($_POST['nome']);

    move_uploaded_file($imagePath,$savePath);

    $user->update();

    header('Location:../View/Func/Gere.User.php');

}
?>