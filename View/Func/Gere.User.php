<?php
    include_once __DIR__ . '../../../Model/User.class.php';
    include_once __DIR__ . '../../../Model/Bike.class.php';

    if(isset($_SESSION['cpfFunc']) && !empty($_SESSION['cpfFunc']) && $_SESSION['papel']=='func'):
      $acao = 'cadastrar';
      $usuarios = Usuario::getAll();

      if(isset($_GET['cpf'])){
        $usuario = new Usuario();
        $usuario->setCPF($_REQUEST['cpf']);
        $bike = new Bike();
        $bike->setCpf($_REQUEST['cpf']);
        $usuario->load(); 
        $bike->load();
        $acao = 'atualizar';

    }else{
        $usuario = new Usuario();
        $bike = new Bike();
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../Css/Gere.User.css" media="screen" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <title>Usuários</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <label><h5>BikeLocker</h5></label>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gerenciar
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="Bicicletario.php">Bicicletário</a></li>
            <li><a class="dropdown-item" href="Gere.User.php">Usuário</a></li>
            <li><a class="dropdown-item" href="Gere.Bike.php">Bicicletas</a></li>
          </ul>
        </li>
      </ul>
      <div class="d-flex" role="search">
        <button class="btn btn-outline-danger" type="submit" onclick="window.location.href='../../Controller/Logout.controller.php'">Sair</button>
    </div>
    </div>
  </div>
</nav>

<div class="formUser">
        <h3>Cadastro Usuários</h3>
        <br>
        <form action= "../../controller/User.controller.php?acao=<?= $acao ?>" method="post" enctype="multipart/form-data">
            <div class="inputBox">
                <input type="text" name="cpf" id="cpf" placeholder="CPF" class="form-control" value="<?= $usuario->getCPF();?>"/>
            </div>
            <br>
            <div class="inputBox">
                <input type="text" name="nome" id="nome" placeholder="Nome" class="form-control" value="<?= $usuario->getNome();?>"/>
            </div>
            <br>
            <div>
                <input type="color" class="form-control form-control-color" id="cor" name="cor" value="<?= $bike->getCor();?>"/>
            </div>
            <br>
            <div class="btn btn-primary btn-rounded">
                <label class="form-label text-white m-1" for="imagem">Choose file</label>
                <input type="file" class="form-control d-none" id="imagem" name="imagem" value=""/>
            </div>
            <br><br>
            <input type="submit" class="btn btn-primary btn-block mb-4" value="Cadastrar">
        </form>
</div>

<div class = "tableUser">
        <table class = "table table-white table-striped-columns table-bordered">
            <thead>
                <tr>
                    <th scope="col">CPF</th>
                    <th scope="col">nome</th>
                    <th scope="col" styler="width:50px;">Funcionalidades</th>
                </tr>
            </thead>    
        <tbody>
            <?php foreach($usuarios as $usuario){?>
                <tr>
                    <th scope="col">
                        <?php echo $usuario->getCPF();?>
                    </th>
                    <td>
                        <?php echo $usuario->getNome();?>
                    </td>
                    <td>
                        <a href="../../Controller/User.controller.php?acao=deletar&id=<?= $usuario->getCPF() ?>" class="btn btn-danger">Excluir</a>
                        <a href="?cpf=<?= $usuario->getCPF() ?>" class="btn btn-success">Editar</a>
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
    header(__DIR__ . "../View/Login.php");
endif;
 ?>