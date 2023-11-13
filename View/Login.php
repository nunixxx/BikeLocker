<?php
    require_once '../Utils/autoload.php'; 
    Conexao::conexao();
    
    session_destroy();


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../Css/Login.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../Css/Geral.css" media="screen" />
    <link rel="shortcut icon" href="../Images/Logo.png" />
    <title>Login</title>
</head>
<body>
    <div class="loginPanel">      
            <img src="../Images/LogoWhite.png" alt="logo"  class="logo">
        <h4>LOGIN</h4>
        <br>
        <form action= "../Controller/Login.controller.php" method="post">
            <label> CPF: </label>
                <input type="text" name="cpf" id="cpf" placeholder="CPF"/>
            <br>
            <label>SENHA:</label>
                <input type="password" name="senha" id="senha" placeholder="Senha"/>
            <br>
            <input type="submit">
        </form>
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
    <script src="../JavaScript/Message.js"></script>
</body>
</html> 