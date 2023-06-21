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
// else if($acao == 'deletar'){
//     Papelfuncionario::delete($_REQUEST['id']);
//     funcionario::delete($_REQUEST['id']);
//     header('Location:../View/Index.php ');

// } else if($acao =='atualizar'){
//     $funcionario = new Funcionario();
//     $funcionario->setNome($_POST['nome']);
//     $funcionario->setEmail($_POST['email']);
//     $funcionario->setSenha($_POST['senha']);
//     $funcionario->setId($_POST['id']);
    
//     $funcionario->update();

//     foreach($_POST["papeis"] as $papel){
//         $papelfuncionario->setIdPapel($papel);
//         $papelfuncionario->save();
//     }

    
//     header('Location:../View/Index.php ');

// } else if($acao == 'atualizarView'){
//     $funcionario = new Funcionario();
//     $funcionario->setID($_REQUEST['id']);
//     $funcionario->load();
// }


?>
