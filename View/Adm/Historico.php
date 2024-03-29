<?php
    require_once __DIR__ . '/../../Utils/autoload.php';
    Conexao::conexao();
    
    $session_timeout = 1800;

    if(isset($_SESSION['loggedin']) && $_SESSION["papel"]=="adm" && time() - $_SESSION['loggedin'] < $session_timeout):

    $_SESSION['loggedin'] = time();
    
    $acao = 'cadastrar';
    $pasta = '../../HistoricosPdf';

    $files = scandir($pasta);

    $files = array_diff($files, array('.', '..',));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../Css/Historico.css" media="screen" />
    <link rel="shortcut icon" href="../../Images/Logo.png" />
    <title>Administraçao</title>
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
        <a class="nav-link" href="Gere.Func.php">Funcionários</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Historico.php"><strong>Histórico</strong></a>
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

<div class="tabela">
    <table class="cabecalho">
        <thead>
            <tr>
                <th style="width: 150px">Data</th>
            </tr>
        </thead>
    </tabel>
    <table>
        <tbody>
            <?php foreach ($files as $file) {?>
            <tr class="item">
                <td style="width: 150px">
                    <strong><?php echo $file?></strong>
                </td>
                <td>
                <div class="btn btn-primary btn-rounded" style ="background-color: #14bf25; border: none; padding: 5px;">
                    <form method="post" action="../../Controller/Historico.controller.php?acao=download&id=<?= $file?>">
                        <input type="image" src="../../Images/nuvemUpload.png" title="download" alt="Submit" style="widht:25px; height:25px;">
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