<?php
class Message {
    private string $tipo;
    private string $conteudo;

    function __construct($encodedMessage = NULL) {
        if (!empty($encodedMessage)) {
            $decodedMessage = base64_decode($encodedMessage);
            $params = explode("&", $decodedMessage);
            
            $this->tipo = str_replace("tipo=", "", $params[0]);
            $this->conteudo = str_replace("conteudo=", "", $params[1]);
        }
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getConteudo() {
        return $this->conteudo;
    }

    public function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }

    public function __toString() {
        return base64_encode("tipo=" . $this->tipo . "&conteudo=" . $this->conteudo);
    }
}