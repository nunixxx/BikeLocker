<?php
require_once __DIR__ .'/../Utils/autoload.php';

session_start();

$session_timeout= 1800;

if(time() - $_SESSION['loggedin'] < $session_timeout){

include_once __DIR__ . '/../Model/Bicicletario.class.php';
include_once __DIR__ . '/../Model/Historico.class.php';
include_once __DIR__ . '/../Model/Bike.class.php';
date_default_timezone_set('America/Sao_Paulo');
    $bicicletarios = Bicicletario::getAll();
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
    $antigo = new Bicicletario();
    $antigo->setLocker($_GET['locker']);
    $antigo->load();
    
    foreach($bicicletarios as $teste){
        echo $_POST['cpf'] . "=" . $teste->getCpf() . " " . $_POST['cpf'] . "=" . $antigo->getCpf() ."<br>";
        if($teste->getCpf() == $_POST['cpf'] && $_POST['cpf'] != $antigo->getCpf()){
            $message = new Message();
            $message->setTipo("danger");
            $message->setConteudo("CPF já ocupado");
            return header('Location:../View/Func/Bicicletario.php?message='. $message->__toString());
        }else if($teste->getLocker() == $_POST['locker'] && $_POST['locker'] != $antigo->getLocker()){
            $message = new Message();
            $message->setTipo("danger");
            $message->setConteudo("Locker já ocupado");
            return header('Location:../View/Func/Bicicletario.php?message='. $message->__toString());
        }
    }
    $bicicletario->setlocker($_POST['locker']);
    $bicicletario->setCpf($_POST['cpf']);
    $bicicletario->setCadeado($_POST['cadeado']);
    $bicicletario->setBikeId($_POST['bike_id']);
    $bicicletario->setChegada($_POST['chegada']);

    $bicicletario->update($_GET['locker']); 
    header('Location:../View/Func/Bicicletario.php');

}
}else{

    $message = new Message();
    $message->setTipo("danger");
    $message->setConteudo("Sessão expirada!");

    header('Location:../View/Login.php?message=' . $message->__toString());
}
?>