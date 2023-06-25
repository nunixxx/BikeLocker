<?php
    require __DIR__ . '../../../DataBase/Conexao.php';
    if(isset($_SESSION['cpfFunc']) && !empty($_SESSION['cpfFunc']) && $_SESSION['papel']=='func'):
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <title>Tela Incial</title>
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>
<?php 
else: 
    header(__DIR__ . "../View/Login.php");
endif;
 ?>