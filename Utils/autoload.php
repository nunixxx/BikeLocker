<?php
function my_autoload ($pClassName) {
    $className = ucfirst($pClassName);

    $file = __DIR__ . "/../Controller/" . $className . ".controller.php";
    if(file_exists($file)){
        include_once $file;
        return ;
    }

    $file = __DIR__ . "/../Model/" . $className . ".class.php";
    if(file_exists($file)){
        include_once $file;
        return ;
    }
    
    $file = __DIR__ . "/" . $className . ".trait.php";
    if(file_exists($file)){
        include_once $file;
        return ;
    }
    
    $file =__DIR__ . "/" . $className . ".php";
    if(file_exists($file)){
        include_once $file;
        return ; 
    }
    $file =__DIR__ . "/" . $className . "/" . $className. ".php";
    if(file_exists($file)){
        include_once $file;
        return ; 
    }
}
spl_autoload_register("my_autoload");
