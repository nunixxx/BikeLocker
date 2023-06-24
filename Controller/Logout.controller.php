<?php
    session_start();
    unset($_SESSION['cpfFunc']);

    header('Location:../View/Login.php');

?>