<?php 
require_once __DIR__ .'/../Utils/autoload.php';
include_once __DIR__ . '/../Model/Bicicletario.class.php';
include_once __DIR__ . '/../Model/Historico.class.php';
include_once __DIR__ . '/../Model/Bike.class.php';


if(isset($_GET['acao'])&& $_GET['acao'] == 'selectedCpf') {

$bikes = Bike::loadByCpf($_GET['cpf']);    

echo json_encode($bikes);
}