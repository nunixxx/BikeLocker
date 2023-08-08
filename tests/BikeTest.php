<?php

use PHPUnit\Framework\TestCase;

require_once "./Model/Bike.class.php";
require_once "./Model/User.class.php";

class BikeTest extends TestCase
{
    private $salvoCpf;
    private $salvoCor;
    private $bike;

    public function setUp(): void
    {
        $this->bike = new Bike();

        $this->salvoCpf = $this->bike->setCpf(60082177058);
        $this->salvoCor = $this->bike->setCor("#501b1b");
    }

    public function tearDown(): void
    {
        $this->bike = null;
    }

    public function testInstanciaBike()
    {
        $this->assertEquals("#501b1b", $this->bike->getCor());
        $this->assertEquals(60082177058, $this->bike->getCpf());
    }
    public function testCpfSucesso()
    {
        $this->assertTrue($this->salvoCpf);
    }

    public function testCpfErro()
    {
        $salvo = $this->bike->setCpf(1);

        $this->assertFalse($salvo);
    }

    public function testCorSucesso()
    {
        $this->assertTrue($this->salvoCor);
    }

    public function testCorErro()
    {
        $salvo = $this->bike->setCor("azul");

        $this->assertFalse($salvo);
    }
}
