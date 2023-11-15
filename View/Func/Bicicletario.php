<?php
  require_once __DIR__ . '/../../Utils/autoload.php';
  include_once __DIR__ . '/../../Model/User.class.php';
  include_once __DIR__ . '/../../Model/Bike.class.php';
  include_once __DIR__ . '/../../Model/Bicicletario.class.php';

  Conexao::conexao();

  $session_timeout = 1800;

  if(isset($_SESSION['loggedin']) && $_SESSION["papel"]=="func" && time() - $_SESSION['loggedin'] < $session_timeout):

  $_SESSION['loggedin'] = time();
      
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
  <link rel="stylesheet" type="text/css" href="../../Css/Geral.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../../Css/Bicicletario.css" media="screen" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../Images/Logo.png" />
  <title>Bicicletario</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <img src="../../Images/Logo.png" style="width:60px; margin-right:10px; margin-left:10px;">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="Bicicletario.php"><strong>Bicicletário</strong></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Gere.User.php">Usuário</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Gere.Bike.php">Bicicletas</a>
      </li>
    </ul>
  </div>
  <div class="d-flex" role="search">
    <button class="btn btn-outline-danger" type="submit"
      onclick="window.location.href='../../Controller/Logout.controller.php'">
      Sair
    </button>
  </div>
</nav>

  <div class="form" style = "color: white">
    <h3>Bicicletário</h3>
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
      <input type="submit" class="btn btn-primary btn-block mb-4" value="Cadastrar" style="background-color: #0c945de3; border: none; border-radius: 0px; font-weight: bold;">
    </form>
      <!-- <a href="../../Utils/SalvarHist.php" target="_blank" class="btn btn-success"> download PDF</a> -->

  </div>

  <div id="ConfDel" class="popup" style="display: none;">
    <div class="popup-conteudo">
        <span class="fechar" id="fecharPopup" onclick="fecharPopup()">&times;</span>
        <p>Deseja mesmo Deletar?</p>
        <input class="btn btn-primary btn-rounded" style ="background-color: #c53302; border: none;" type="submit" id="enviarFormulario" value="Sim" onclick="enviarFormulario()">
    </div>
  </div>

  <div class="tabela">
    <table class="cabecalho">
      <thead>
        <tr>
          <th style="width: 10%;">Locker</th>
          <th style="width: 30%;">Usuário</th>
          <th style="width: 20%;">Bicicleta</th>
          <th style="width: 50%;">Horario</th>
        </tr>
      </thead>
    </table>

    <table>
      <tbody>
        <?php foreach($bicicletarios as $bicicletario){?>
        <tr class="item">
          <td style="width: 10%; text-align: center;">
            <strong><?php echo $bicicletario->getLocker();?></strong>
          </td>
          <td style="width: 30%; margin-left: 40px;">
            <?php echo User::loadByCpf($bicicletario->getCpf());?>
          </td>
          <td style="width: 20%;">
          <div style="width: 70px;">
            <img class= "bikeImg" src="../../Arquivos/<?php echo $bicicletario->getBikeId();?>.png" for="imagem"/>
          </div>
          </td>
          <td style="width: 20%;">
            <?php $dataFormat = date("d/m H:i", strtotime($bicicletario->getChegada()));
             echo $dataFormat;?>
          </td>
          <td style="width: 30%;">
          <div class="btn btn-primary btn-rounded" style ="background-color: #c53302; border: none; padding: 5px;">
              <form id= "deletar" method="post" action="../../Controller/Bicicletario.controller.php?acao=deletar&locker=<?= $bicicletario->getlocker() ?>">
                  <input type="image" src="../../Images/Lixeira.png" title="deletar" alt="Submit" style="widht:25px; height:25px;">
              </form>
          </div>
          <div class="btn btn-primary btn-rounded" style ="background-color: #14bf25; border: none; padding: 5px;">
              <form method="post" action="?locker=<?= $bicicletario->getLocker() ?>">
                  <input type="image" src="../../Images/Editar.png" title="editar" alt="Submit" style="widht:25px; height:25px;">
              </form>
          </div>
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
  $message = new Message();
  $message->setTipo("danger");
  $message->setConteudo("Sessão expirada!");

  header('Location:../../View/Login.php?message=' . $message->__toString());
endif;
 ?>