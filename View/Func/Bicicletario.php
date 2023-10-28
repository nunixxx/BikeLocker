<?php
  include_once __DIR__ . '/../../Model/User.class.php';
  include_once __DIR__ . '/../../Model/Bike.class.php';
  include_once __DIR__ . '/../../Model/Bicicletario.class.php';

  Conexao::conexao();
    if(isset($_SESSION['cpfFunc']) && !empty($_SESSION['cpfFunc']) && $_SESSION['papel']=='func'):
      
      $bicicletarios = Bicicletario::getAll();
      $users = User::getAll();
      $bikes = Bike::getAll();
      $acao = 'cadastrar';

      if(isset($_GET['locker'])){
        $bicicletario = new Bicicletario();
        $bicicletario->setLocker($_REQUEST['locker']);

        $bicicletario->load(); 
        $acao = 'atualizar';

    }else{
        $bicicletario = new Bicicletario();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="../../Css/Bicicletario.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../../Css/Geral.css" media="screen" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

  <div class="form" style = "color: white">
    <h3>Bicicletario</h3>
    <br>
    <form action="../../Controller/Bicicletario.controller.php?acao=<?= $acao ?>" method="post" enctype="multipart/form-data">
      <label> Usuário </label><br>
      <select class="form-select" aria-label="Default select example" id="cpf" name="cpf" required onchange="updateBikeOptions()">
        <option value="" disabled selected>
          <?php if(null == $bicicletario->getCpf() ){echo "CPF";} else{echo $bicicletario->getCpf();}  ?>
        </option>
        <?php 
          foreach ($users as $user){
            ?>
        <option value=<?=$user->getCpf();?>>
          <?= $user->getCpf();?>
        </option>
        <?php
          }
          ?>
      </select>
      <br>
      <label> Bicicleta </label><br>
          <select class="form-select" aria-label="Default select example" id="bike_id" name="bike_id" required>
        <option value="" disabled selected>
          <?php if(null == $bicicletario->getBikeId() ){echo "ID";} else{echo $bicicletario->getBikeId();}  ?>
        </option>
        <?php 
          foreach ($bikes as $bike){
            ?>
        <option value=<?=$bike->getId();?>>
          <?= $bike->getId();?>
        </option>
        <?php
          }
          ?>
      </select>
      <br>
      <label> Locker </label>
      <br>
      <div class="inputBox">
        <select class="form-select" aria-label="Default select example" id="locker" name="locker" required>
          <option value="" disabled selected>
          <?php if(null == $bicicletario->getLocker () ){echo "Locker";} else{echo $bicicletario->getLocker();}  ?>
          </option>
          <?php
            for ($i = 1; $i <= 50; $i++){

          ?>
          <option value=<?=$i ?>>
            <?= $i?>
          </option>
          <?php
            }
            ?>
        </select>
      </div>
      <br>
      <label> Cadeado </label>
      <br>
      <div class="toggles">
        <input class="cadeado" type="radio" name="cadeado" id="1" value="1" <?php if($bicicletario->getCadeado() == 1){echo "checked";} ?> required>
          <label for="1">Possui</label>
        <input class="cadeado" type="radio" name="cadeado" id="0" value="0" <?php if($bicicletario->getCadeado() !== null && $bicicletario->getCadeado() == 0){echo "checked";}?>>
          <label for="0">Não Possui </label>
      </div>
      <input type="submit" class="btn btn-primary btn-block mb-4" value="cadastrar">
    </form>
      <a href="../../Controller/Bicicletario.controller.php?acao=pdf" target="_blank" class="btn btn-success"> download PDF</a>

  </div>
  <div class="tabela">
    <table class="cabecalho">
      <thead>
        <tr>
          <th>Locker</th>
          <th>Usuário</th>
          <th>Bike</th>
          <th>Horario</th>
          <th>Ações</th>
        </tr>
      </thead>
    </table>

    <table>
      <tbody>
        <?php foreach($bicicletarios as $bicicletario){?>
        <tr class="item">
          <th>
            <?php echo $bicicletario->getLocker();?>
          </th>
          <td>
            <?php echo $bicicletario->getCpf();?>
          </td>
          <td>
          <img class= "bikeImg" src="../../Arquivos/<?php echo $bicicletario->getBikeId();?>.png" for="imagem"/>
          </td>
          <td>
            <?php $dataFormat = date("d/m H:i", strtotime($bicicletario->getChegada()));
             echo $dataFormat;?>
          </td>
          <td>
            <a href="../../Controller/Bicicletario.controller.php?acao=deletar&locker=<?= $bicicletario->getlocker() ?>"
              class="btn btn-danger">Excluir</a>
            <a href="?locker=<?= $bicicletario->getLocker() ?>" class="btn btn-success">Editar</a>
          </td>
        </tr>
        <?php } ?>
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="../../JavaScript/Message.js"></script>
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