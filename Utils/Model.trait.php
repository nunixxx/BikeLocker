<?php
require_once '../Utils/autoload.php';

trait Model {

    public function __get($quem){
        $metodo = 'get'. ucfirst($quem);
        if(method_exists($this, $metodo)){
            return $this->{$metodo}();

        }
        return $this->{$quem};
    }

    public function __set($quem, $valor){
        $this->{$quem} = $valor;
    }

}