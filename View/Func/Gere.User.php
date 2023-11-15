<?php
    require_once __DIR__ . '/../../Utils/autoload.php';
    include_once __DIR__ . '/../../Model/User.class.php';
    include_once __DIR__ . '/../../Model/Bike.class.php';
    Conexao::conexao();
   
    $session_timeout = 1800;
  
    if(isset($_SESSION['loggedin']) && $_SESSION["papel"]=="func" && time() - $_SESSION['loggedin'] < $session_timeout):
  
    $_SESSION['loggedin'] = time();
    
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../Css/Gere.User.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../../Css/Geral.css" media="screen" />
    <link rel="shortcut icon" href="../../Images/Logo.png" />
    <title>Usuários</title>
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
        <a class="nav-link" href="Gere.User.php"><strong>Usuário</strong></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Gere.Bike.php">Bicicletas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Histórico</a>
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
        <h3>Cadastro Usuários</h3>
        <br>
        <form action= "../../Controller/User.controller.php?acao=<?= $acao ?>" method="post" enctype="multipart/form-data">
            <div class="inputBox">
                <input type="text" name="cpf" id="cpf" placeholder="CPF" value="<?= $user->getCpf();?>" <?php
            if(!isset($_GET['cpf'])){
            ?>required <?php
        }else{?>
            readonly
        <?php
        }
        ?>/>
            </div>
            <br>
            <div class="inputBox">
                <input type="text" name="nome" id="nome" placeholder="Nome" value="<?= $user->getNome();?>"required/>
            </div>
            <br>
            <?php
            if(!isset($_GET['cpf'])){
            ?>
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
            <?php
            }else{?>
                <button id="limparURL">Cancelar</button>
            <?php }?>
            <br><br>
            <input type="submit" value="Cadastrar">
        </form>
        <label style="position: fixed; bottom: 10px; right: 10px;"> *Todos os campos devem ser preenchidos</label>
    </div>

    <div id="fotoSelect" class="fotoSelect" style=" display:none;">
        <img id="imagemSelecionada" src="#" alt="Imagem Selecionada" style=" max-width: 100px; max-height: 100px;"/>
    </div>    

    <div id="ConfDel" class="popup" style="display: none;">
        <div class="popup-conteudo">
            <span class="fechar" id="fecharPopup" onclick="fecharPopup()">&times;</span>
            <p>Deseja mesmo Deletar?</p>
            <input class="btn btn-primary btn-rounded" style ="background-color: #c53302; border: none;" type="submit" id="enviarFormulario" value="Sim" onclick="enviarFormulario('<?= $user->getCpf() ?>')">
        </div>
    </div>

    <div class="tabela" style="width: 500px;">
        <table class="cabecalho">
            <thead>
                <tr>
                    <th style="width: 150px;">CPF</th>
                    <th>Nome</th>
                </tr>
            </thead> 
        </table>   
        <table>
            <tbody>
                <?php foreach($users as $user){?>
                <tr class="item">
                    <td style="width: 150px;">
                        <strong><?php echo $user->getCpf();?></strong>
                    </td>
                    <td>
                        <?php echo $user->getNome();?>
                    </td>
                    <td>
                    <div class="btn btn-primary btn-rounded" style ="background-color: #c53302; border: none; padding: 5px;">
                        <form id= "deletar" class="deletar" method="post" action="../../Controller/User.controller.php?acao=deletar&id=<?= $user->getCpf() ?>">
                            <input type="image"src="../../Images/Lixeira.png" title="deletar" alt="Submit" style="widht:25px; height:25px;">
                        </form>
                    </div>
                    <div class="btn btn-primary btn-rounded" style ="background-color: #14bf25; border: none; padding: 5px;">
                        <form id= "editar" class="editar" method="post" action="?cpf=<?= $user->getCpf() ?>">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="../../JavaScript/Message.js"></script>
<script src="../../JavaScript/Gere.Bike.js"></script>
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