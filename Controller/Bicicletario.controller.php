<?php
require_once __DIR__ .'/../Utils/autoload.php';
include_once __DIR__ . '/../Model/Bicicletario.class.php';
include_once __DIR__ . '/../Model/Historico.class.php';
date_default_timezone_set('America/Sao_Paulo');
    
    $bicicletario = new Bicicletario();
    $horarioAtual = date('Y-m-d H:i:s');

if ($_GET['acao']== 'cadastrar'){

    $bicicletario->setlocker($_POST['locker']);
    $bicicletario->setCpf($_POST['cpf']);
    $bicicletario->setCadeado($_POST['cadeado']);
    $bicicletario->setChegada($horarioAtual);
    $bicicletario->setBikeId($_POST['bike_id']);

    $bicicletario->save();

    header('Location:../View/Func/Bicicletario.php');
}

else if($_GET['acao']== 'deletar'){
    $historico= new Historico();
    $bicicletario->setLocker($_REQUEST['locker']);

    $bicicletario->load(); 

    $historico->setlocker($bicicletario->getLocker());
    $historico->setCpf($bicicletario->getCpf());
    $historico->setCadeado($bicicletario->getCadeado());
    $historico->setChegada($bicicletario->getChegada());
    $historico->setBikeId($bicicletario->getBikeId());
    $historico->setSaida($horarioAtual);

    $historico->save();

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