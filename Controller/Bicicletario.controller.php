<?php
require_once __DIR__ .'/../Utils/autoload.php';

session_start();

$session_timeout= 1800;

if(time() - $_SESSION['loggedin'] < $session_timeout){

include_once __DIR__ . '/../Model/Bicicletario.class.php';
include_once __DIR__ . '/../Model/Historico.class.php';
include_once __DIR__ . '/../Model/Bike.class.php';
date_default_timezone_set('America/Sao_Paulo');
    
    $bicicletario = new Bicicletario();
    $horarioAtual = date('Y-m-d H:i:s');

if (isset($_GET['acao']) && $_GET['acao']== 'cadastrar'){
    $bicicletario->setlocker($_POST['locker']);
    $bicicletario->setCpf($_POST['cpf']);      

    $temp = $bicicletario->loadCheck();
    echo $temp;
    if($temp == false){
        $bicicletario->setlocker($_POST['locker']);
        $bicicletario->setCpf($_POST['cpf']);
        $bicicletario->setCadeado($_POST['cadeado']);
        $bicicletario->setChegada($horarioAtual);
        $bicicletario->setBikeId($_POST['bike_id']);

        $bicicletario->save();

        header('Location:../View/Func/Bicicletario.php');
    }else {
        $message = new Message();
        $message->setTipo("danger");
        $message->setConteudo("Locker ou CPF já ocupado");

        header('Location:../View/Func/Bicicletario.php?message='. $message->__toString());
    }


    }

else if(isset($_GET['acao']) && $_GET['acao']== 'deletar'){
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
    
} else if(isset($_GET['acao']) && $_GET['acao']== 'atualizar'){
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

} else if(isset($_GET['acao']) && $_GET['acao'] == 'pdf'){
    Historico::createPdf();
}
}else{

    $message = new Message();
    $message->setTipo("danger");
    $message->setConteudo("Sessão expirada!");

    header('Location:../View/Login.php?message=' . $message->__toString());
}
?>