<?php

use PHPUnit\Framework\TestCase;

require_once './Model/User.class.php';

class UsuarioBDTest extends TestCase{
   
    private $user;
    private $salvo;
    
    public function setUp() : void 
    {
        $this->user = new Usuario();

        $this->user->setNome("Caio");
        $this->user->setCpf(60082177054);

        $this->salvo = $this->user->save();       
    }

    public function tearDown() : void
    {
        $deletado = $this->user->delete($this->user->getCpf());

        $this->assertTrue($deletado);
    }

    public function testSaveUser(){

        $this->assertTrue($this->salvo);
    }

    public function testUpdateUser(){
        $user = $this->user;

        $this->user->setNome('Jose');
        $atualizado = $this->user->update();

        $this->assertTrue($atualizado);

        $this->assertEquals($this->user->getCpf(), $user->getCpf());
        $this->assertEquals($this->user->getNome(), $user->getNome());

    }
    public function testLoadUser(){
        $user = new Usuario();

        $user->setCpf(60082177054);
        $user->load();

        $this->assertEquals($this->user->getCpf(), $user->getCpf());
        $this->assertEquals($this->user->getNome(), $user->getNome());
    }
}
?>
