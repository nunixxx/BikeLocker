<?php
require_once __DIR__ .'/../Utils/autoload.php';
include_once __DIR__ . '/../Model/Bike.class.php';


if ($_GET['acao']== 'cadastrar'){

    $bike = new Bike();
    $bike->setCor($_POST['cor']);
    $bike->setCpf( $_POST['cpf']);
    $bike->save();

    $imageName = $bike->getId();

    $savePath = '../Arquivos/'.$imageName.'.png';
    $imagePath = $_FILES['imagem']['tmp_name'];

    move_uploaded_file($imagePath,$savePath);
    header('Location:../View/Func/Gere.Bike.php');
}

else if($_GET['acao']== 'deletar'){
    Bike::delete($_REQUEST['id']);  
    header('Location:../View/Func/Gere.Bike.php');
    
} else if($_GET['acao']== 'atualizar'){
    $bike = new Bike();
    $bike->setCor($_POST['cor']);
    $bike->setCpf( $_POST['cpf']);
    $bike->setId($_REQUEST['id']);
    $imageName = $bike->getId();

    $savePath = '../Arquivos/'.$imageName.'.png';
    $imagePath = $_FILES['imagem']['tmp_name'];

    move_uploaded_file($imagePath,$savePath);
    
    move_uploaded_file($imagePath,$savePath);

    $bike->update(); 
    header('Location:../View/Func/Gere.Bike.php');

} else if($_GET['acao'] == 'pesquisar'){
    
}

?>