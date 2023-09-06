<?php

use PHPUnit\Framework\TestCase;

require_once './Model/Bike.class.php';
require_once './Model/User.class.php';


class BikeBDTest extends TestCase{
    private $bike;
    private $user;
    private $salvo;
    
    public function setUp() : void 
    {
        $this->bike = new Bike();

        $this->bike->setCpf(60082177058);
        $this->bike->setCor('#501b1b');

        $this->user = new User();

        $this->user->setNome("Caio");
        $this->user->setCpf(60082177058);


        $this->user->save();
        $this->salvo = $this->bike->save();      
    }

    public function tearDown() : void
    {
        $deletado = $this->bike->delete($this->bike->getCpf());
        $this->user->delete($this->user->getCpf());

        $this->assertTrue($deletado);
    }

    public function testSavebike(){

        $this->assertTrue($this->salvo);
    }

    public function testUpdatebike(){
        $bike = $this->bike;

        $this->bike->setCor('#501b12');
        $atualizado = $this->bike->update();

        $this->assertTrue($atualizado);

        $this->assertEquals($this->bike->getCpf(), $bike->getCpf());
        $this->assertEquals($this->bike->getId(), $bike->getId());
        $this->assertEquals($this->bike->getCor(), $bike->getCor());

    }

    public function testLoadbike(){
        $bike = new Bike();

        $bike->setCpf(60082177058);
        $bike->load();

        $this->assertEquals($this->bike->getCpf(), $bike->getCpf());
        $this->assertEquals($this->bike->getId(), $bike->getId());
        $this->assertEquals($this->bike->getCor(), $bike->getCor());
    }
}