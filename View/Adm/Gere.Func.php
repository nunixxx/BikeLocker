<?php
    require_once __DIR__ . '/../../Utils/autoload.php';
    Conexao::conexao();
    
    $session_timeout = 1800;

    if(isset($_SESSION['loggedin']) && $_SESSION["papel"]=="adm" && time() - $_SESSION['loggedin'] < $session_timeout):

    $_SESSION['loggedin'] = time();
    
    $acao = 'cadastrar';
    $funcionarios = Funcionario::getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../Css/Gere.Func.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../../Css/Geral.css" media="screen" />
    <link rel="shortcut icon" href="../../Images/Logo.png" />
    <title>Administraçao</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <label>BikeLocker</label>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Gerenciar
                        </a>
                    </li>
                </ul>
                <div class="d-flex" role="search">
                    <button class="btn btn-outline-danger" type="submit"
                        onclick="window.location.href='../../Controller/Logout.controller.php'">Sair</button>
                </div>
            </div>
        </div>
    </nav>
    <div class="form">
        <h3>Cadastro</h3>
        <br>
        <form action="../../Controller/Func.controller.php?acao=<?= $acao ?>" method="post" style="padding: 30px">
                <input type="text" name="cpf" id="cpf" placeholder="CPF" />
            <br>
                <input type="text" name="nome" id="nome" placeholder="Nome" />
            <br>
                <input type="email" name="email" id="email" placeholder="E-mail" />
            <br>
                <input type="password" name="senha" id="senha" placeholder="Senha" />
            <input type="hidden" name="papel" id="papel" value='func' />
            <br>
            <input type="submit" value="Cadastrar">
        </form>
    </div>
    <div class="tabela">
        <table class="cabecalho">
            <thead>
                <tr>
                    <th style="width: 150px">CPF</th>
                    <th style=" width: 150px">nome</th>
                    <th>Email</th>
                </tr>
            </thead>
        </tabel>
        <table>
            <tbody>
                <?php foreach($funcionarios as $funcionario){
                    if($funcionario->getPapel() =="func"){?>
                <tr class="item">
                    <td style="width: 150px">
                        <strong><?php echo $funcionario->getCpf();?></strong>
                    </td>
                    <td style=" width: 150px">
                        <?php echo $funcionario->getNome();?>
                    </td>
                    <td>
                        <?php echo $funcionario->getEmail();?>
                    </td>
                    <td>
                        <a href="../../Controller/Func.controller.php?acao=deletar&id=<?= $funcionario->getCpf() ?>"
                            class="btn btn-danger">Excluir</a>
                    </td>
                </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>

    <?php
            if (!empty($_GET["message"])) {
                $message = new Message($_GET["message"]);

                echo "
                    <div id='messageBox' class='alert alert-" . $message->getTipo() . "' role='alert'>
                        " . $message->getConteudo() . "
                    </div>
                ";
            }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>
<?php 
else: 

    $message = new Message();
    $message->setTipo("danger");
    $message->setConteudo("Sessão expirada!");

    header('Location:../../View/Login.php?message=' . $message->__toString());
endif;
 ?>