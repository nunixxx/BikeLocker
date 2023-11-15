<?php
require_once __DIR__ .'/../Utils/autoload.php';

session_start();

$session_timeout= 1800;

if(time() - $_SESSION['loggedin'] < $session_timeout){

include_once __DIR__ . '/../Model/Historico.class.php';
date_default_timezone_set('America/Sao_Paulo');
if(isset($_GET['acao']) && $_GET['acao'] == 'download'){
        
        $file=$_GET['id'];

        $pasta = '../HistoricosPdf/';

        // Caminho completo do arquivo
        $filepath = $pasta . $file;
    
        // Verifica se o arquivo existe
        if (file_exists($filepath)) {
            // Configurações do cabeçalho para iniciar o download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
    
            // Lê o arquivo e envia para o navegador
            readfile($filepath);
            exit;
        } else {
            echo 'O arquivo não existe.';
        }
}

}