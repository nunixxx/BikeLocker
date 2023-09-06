<?php
function my_autoload ($pClassName) {
    
    $file = __DIR__ . "/../Controller/" . $pClassName . ".controller.php";
    if(file_exists($file)){
        include_once $file;
        return ;
    }

    $file = __DIR__ . "/../Model/" . $pClassName . ".class.php";
    if(file_exists($file)){
        include_once $file;
        return ;
    }
    
    $file = __DIR__ . "/" . $pClassName . ".trait.php";
    if(file_exists($file)){
        include_once $file;
        return ;
    }
    
    $file =__DIR__ . "/" . $pClassName . ".php";
    if(file_exists($file)){
        include_once $file;
        return ; 
    }

    //Versão recursiva (muito cuidado)


}
spl_autoload_register("my_autoload");
