<?php
  require_once __DIR__ . '/../../Utils/autoload.php';
  include_once __DIR__ . '/../../Model/User.class.php';
  include_once __DIR__ . '/../../Model/Bike.class.php';

  Conexao::conexao();
    if(isset($_SESSION['cpfFunc']) && !empty($_SESSION['cpfFunc']) && $_SESSION['papel']=='func'):
      
      $users = User::getAll();
      $acao = 'cadastrar';

      if(isset($_GET['cpf'])){
        $user = new User();
        $user->setCpf($_REQUEST['cpf']);
        $bike = new Bike();
        $user->load(); 
        $acao = 'atualizar';

    }else{
        $user = new User();
        $bike = new Bike();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="../../Css/Bicicletario.css" media="screen" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />

  <title>Tela Incial</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <label>
        <h5>BikeLocker</h5>
      </label>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Gerenciar
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="Bicicletario.php">Bicicletário</a>
              </li>
              <li>
                <a class="dropdown-item" href="Gere.User.php">Usuário</a>
              </li>
              <li>
                <a class="dropdown-item" href="Gere.Bike.php">Bicicletas</a>
              </li>
            </ul>
          </li>
        </ul>
        <div class="d-flex" role="search">
          <button class="btn btn-outline-danger" type="submit"
            onclick="window.location.href='../../Controller/Logout.controller.php'">
            Sair
          </button>
        </div>
      </div>
    </div>
  </nav>

  <div class="formBicicletario">
    <h3>Bicicletario</h3>
    <br>
    <form action="../../Controller/Bicicletario.controller.php?acao=<?= $acao ?>" method="post" enctype="multipart/form-data">
    <select class="form-select" aria-label="Default select example" id="cpf" name="cpf">
        <option><?= $bike->getCpf();?></option>
        <?php 
          foreach ($users as $user){
            ?>
        <option value=<?= $user->getCpf();?>><?= $user->getCpf();?></option>
        <?php
          }
          ?>
    </select>
    <br>
      <div class="inputBox">
        <select class="form-select" aria-label="Default select example" id="locker" name="locker">
          <option></option>
          <?php
            for ($i = 1; $i <= 50; $i++){

          ?>
          <option value=""><?= $i?></option>
          <?php
            }
            ?>
        </select>
      </div>
      <br>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="cadeado" id="cadeado">
        <label class="form-check-label" for="cadeado">
          Possui
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="cadeado" id="cadeado" checked>
        <label class="form-check-label" for="cadeado">
          Não Possui
        </label>
      </div>

      <input type="submit" class="btn btn-primary btn-block mb-4" value="cadastrar">
    </form>

  </div>

  <div class = "tableBicicletario">
        <table class = "table table-white table-striped-columns table-bordered">
            <thead>
                <tr>
                    <th scope="col">Locker</th>
                    <th scope="col">Usuário</th>
                    <th scope="col" styler="width:30px;">Funcionalidades</th>
                </tr>
            </thead>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="../../JavaScript/Bicicletario.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>

</html>
<?php 
else: 
    header('Location: ../../View/Login.php');
endif;
 ?>