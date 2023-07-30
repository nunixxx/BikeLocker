<?php
    include_once '../../Model/Funcionario.class.php';

    if(isset($_SESSION['cpfFunc']) && !empty($_SESSION['cpfFunc']) && $_SESSION['papel']=='adm'):

    $acao = 'cadastrar';
    $funcionarios = Funcionario::getAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../Css/Gere.Func.css" media="screen" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <label>Navbar</label>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gerenciar
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Bicicletário</a></li>
            <li><a class="dropdown-item" href="#">Usuário</a></li>
            <li><a class="dropdown-item" href="#">Bicicletas</a></li>
          </ul>
        </li>
      </ul>
      <div class="d-flex" role="search">
        <button class="btn btn-outline-danger" type="submit" onclick="window.location.href='../../Controller/Logout.controller.php'">Sair</button>
    </div>
    </div>
  </div>
</nav>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>
<?php 
else: 
    header('Location: ../../View/Login.php');
endif;
 ?>