<?php
    session_start();
    unset($_SESSION['cpfFunc']);

    header('Location:../public_html/Login.php');

?>