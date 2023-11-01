<?php
require_once __DIR__ .'/../Utils/autoload.php';
include_once __DIR__ . '/../Model/User.class.php';
include_once __DIR__ . '/../Model/Bike.class.php';
include_once __DIR__ . '/../Model/Bicicletario.class.php';

$acao = $_GET['acao'];

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
    $temp = Bicicletario::loadByUser($_REQUEST['id']);
    
    if($temp == false){
        Bike::deleteUser($_REQUEST['id']);
        User::delete($_REQUEST['id']); 
        
        header('Location:../View/Func/Gere.User.php');

    }else{
        $message = new Message();
        $message->setTipo("danger");
        $message->setConteudo("Usuario cadastrado no Bicicletario");

        header('Location:../View/Func/Gere.User.php?message=' . $message->__toString());
    }   
    
    
} else if($acao == 'atualizar'){
    $user = new User();
    $user->setCpf($_POST['cpf']);
    $user->setNome($_POST['nome']);

    move_uploaded_file($imagePath,$savePath);

    $user->update();

    header('Location:../View/Func/Gere.User.php');

}
?>