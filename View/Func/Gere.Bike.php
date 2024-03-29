<?php
    include_once __DIR__ . '/../../Model/Bike.class.php';
    include_once __DIR__ . '/../../Model/User.class.php';

    Conexao::conexao();
   
    $session_timeout = 1800;
  
    if(isset($_SESSION['loggedin']) && $_SESSION["papel"]=="func" && time() - $_SESSION['loggedin'] < $session_timeout):
  
    $_SESSION['loggedin'] = time();

      $users = User::getAll();
      $bikes = Bike::getAll();
      $acao = 'cadastrar';

      if(isset($_GET['id'])){
        $bike = new Bike();
        $bike->setId($_REQUEST['id']);
 
        $bike->load();
        $acao = 'atualizar';

    }else{
        $bike = new Bike();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../Css/Gere.Bike.css" media="screen" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../../Css/Geral.css" media="screen" />
    <link rel="shortcut icon" href="../../Images/Logo.png" />
    <title>Bicicletas</title>
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
        <a class="nav-link" href="Bicicletario.php">Bicicletário</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Gere.User.php">Usuário</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Gere.Bike.php"><strong>Bicicletas</strong></a>
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

  <div class="form">
    <h3>Cadastro Bicicletas</h3>
    <br>
    <form action="../../Controller/Bike.controller.php?acao=<?= $acao ?>" method="post" enctype="multipart/form-data">
      <div class="inputBox" style = "witdh: 20px">
        <input type="text" name="id" id="id" placeholder="ID" value="<?= $bike->getId();?>"
          readonly />
      </div>
      <br>
      <select class="form-select" aria-label="Default select example" id="cpf" name="cpf" required>
        <option value="">
          <?php if(null == $bike->getCpf() ){echo "CPF";} else{echo $bike->getCpf();}  ?>
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
      <br>
      <div>
        <label>Cor da Bicicleta</label>
        <input type="color" id="cor" name="cor" value="<?= $bike->getCor();?>" required/>
      </div>
      <br>
      <div class="btn btn-primary btn-rounded" style ="background-color: #0c945de3; border: none;">
        <img src="../../Images/nuvemUpload.png" for="imagem" style="width: 30px; height: 30px;"/>
        <label class="imageButton" for="imagem"> <strong>Insira a Bicicleta</strong></label>
        <input type="file" class="form-control d-none" id="imagem" onchange="validateFile(); exibirImagemSelecionada();" name="imagem" required accept="image/jpeg, image/png"/>
      </div>
      <br><br>
      <input type="submit"  value="Cadastrar">
    </form>
    <br>
    <?php if(isset($_GET['id'])){?>
        <button id="limparURL">Cancelar</button>
        <br>
    <?php }?>
    <label style="position: fixed; bottom: 10px; right: 10px;"> *Todos os campos devem ser preenchidos</label>
  </div>
  <?php if (isset($_GET['id'])){?>
  <div id="fotoSelect" class="fotoSelect">
        <label>Foto Atual</label><br>
        <img id="imagemSelecionada" src="../../Arquivos/<?= $_GET['id']?>.png" alt="Bike Selecionada" style=" max-width: 100px; max-height: 100px;"/>
  </div>
  <?php }?>
  
  <div id="fotoSelect" class="fotoSelect" style=" display:none;">
    <img id="imagemSelecionada" src="#" alt="Imagem Selecionada" style=" max-width: 100px; max-height: 100px;"/>
  </div>
  
  <div class="tabela" style="width: 450px;">
    <table class="cabecalho">
      <thead>
        <tr>
          <th style="width: 50px">ID</th>
          <th style="width: 150px">CPF</th>
          <th>Cor</th>
        </tr>
      </thead>
    </table>

    <table>
      <tbody>
        <?php foreach($bikes as $bike){?>
        <tr class="item">
          <td style="width: 50px; text-align: center;">
            <strong><?php echo $bike->getId();?></strong>
          </td>
          <td style="width: 150px">
            <strong><?php echo $bike->getCpf();?></strong>
          </td>
          <td>
          <div id="color-box" style="background-color: <?php echo $bike->getCor(); ?>"></div>
          </td>
          <td>
          <div class="btn btn-primary btn-rounded btn-excluir" style ="background-color: #c53302; border: none; padding: 5px;">
            <form id="deletar" class= "deletar" method="post" action="../../Controller/Bike.controller.php?acao=deletar&id=<?= $bike->getId() ?>" onsubmit="return confirmarEnvio()">
                <input type="image" src="../../Images/Lixeira.png" title="deletar" alt="Submit" style="widht:25px; height:25px;">
            </form>
          </div>
          <div class="btn btn-primary btn-rounded" style ="background-color: #14bf25; border: none; padding: 5px;">
              <form method="post" class="editar" action="?id=<?= $bike->getId() ?>">
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
  <script src="../../JavaScript/Gere.Bike.js"></script>
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