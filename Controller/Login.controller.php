<?php
include_once '../Model/Funcionario.class.php';
$acao = $_GET['acao'];

$funcionarios = Funcionario::getAll();
$quantFunc = sizeof($funcionarios);

if($acao == 'login'){
    $funcionarios = new Funcionario();
    $funcionario->setCpf($_POST['cpf']);
    $funcionario->setSenha($_POST['senha']);

        for($i=0; $i<=$quantFunc; $i++)
        {
            if($funcionario->getCPF() == $funcionarios[$i]->getCPF() && $funcionario->getSenha() == $funcionarios[$i]->getSenha())
            {
                header('Location:../View/teste.html');
            }
        }
    echo 'func no encotrado';

}