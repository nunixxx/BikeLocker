<?php
require_once __DIR__ .'/../Utils/autoload.php';
include_once __DIR__ . '/../Model/Bicicletario.class.php';
date_default_timezone_set('America/Sao_Paulo');
  $horarioAtual = date('Y-m-d H:i:s');

if ($_GET['acao']== 'cadastrar'){
    $bicicletario = new Bicicletario();

    $bicicletario->setlocker($_POST['locker']);
    $bicicletario->setCpf($_POST['cpf']);
    $bicicletario->setCadeado($_POST['cadeado']);
    $bicicletario->setChegada($horarioAtual);
    $bicicletario->setBikeId($_POST['bike_id']);

    $bicicletario->save();

    header('Location:../View/Func/Bicicletario.php');
}

else if($_GET['acao']== 'deletar'){
    Bicicletario::delete($_REQUEST['locker']);  
    header('Location:../View/Func/Bicicletario.php');
    
} else if($_GET['acao']== 'atualizar'){
    $bike = new Bike();
    $bike->setCor($_POST['cor']);
    $bike->setCpf( $_POST['cpf']);
    $bike->setId($_REQUEST['id']);
    $imageName = $bike->getId();

    $savePath = '../Arquivos/'.$imageName.'.png';
    $imagePath = $_FILES['imagem']['tmp_name'];

    move_uploaded_file($imagePath,$savePath);

    $bike->update(); 
    header('Location:../View/Func/Bicicletario.php');

} else if($_GET['acao'] == 'pesquisar'){
    
}

?>