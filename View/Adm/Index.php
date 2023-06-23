<?php
    include_once '../../Model/Funcionario.class.php';
    include_once '../../DataBase/Conexao.php';
    $acao = 'cadastrar';

    $funcionarios = Funcionario::getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../Css/Index.css" media="screen" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="formFunc">
        <h3>Cadastro</h3>
        <br>
        <form action= "../../controller/Func.controller.php?acao=<?= $acao ?>" method="post">
            <div class="inputBox">
                <input type="text" name="cpf" id="cpf" placeholder="CPF" class="form-control"/>
            </div>
            <br>
            <div class="inputBox">
                <input type="text" name="nome" id="nome" placeholder="Nome" class="form-control"/>
            </div>
            <br>
            <div class="inputBox">
                <input type="email" name="email" id="email" placeholder="E-mail" class="form-control"/>
            </div>
            <br>
            <div class="inputBox">
                <input type="password" name="senha" id="senha" placeholder="Senha" class="form-control"/>
            </div>
            <input type="hidden" name="papel" id="papel" value='func'/>
            <br>
            <input type="submit" class="btn btn-primary btn-block mb-4" value="Cadastrar">
        </form>
    </div>
    <div class = "tableFuncs">
        <table class = "table table-white table-striped-columns table-bordered">
            <thead>
                <tr>
                    <th scope="col">CPF</th>
                    <th scope="col">nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Senha</th>
                    <th scope="col" styler="width:50px;">Funcionalidades</th>
                </tr>
            </thead>    
        <tbody>
            <?php foreach($funcionarios as $funcionario){?>
                <tr>
                    <th scope="col">
                        <?php echo $funcionario->getCPF();?>
                    </th>
                    <td>
                        <?php echo $funcionario->getNome();?>
                    </td>
                    <td>
                        <?php echo $funcionario->getEmail();?>
                    </td>
                    <td>
                        <?php echo $funcionario->getSenha();?>
                    </td>
                    <td>
                        <a href="../../Controller/Func.controller.php?acao=deletar&id=<?= $funcionario->getCPF() ?>" class="btn btn-danger">Excluir</a>
                    </td>

                    <br>
                </tr>
            <?php } ?>
        </tbody>
            </table>
    </div>

</body>

</html>