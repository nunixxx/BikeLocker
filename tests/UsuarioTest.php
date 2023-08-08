<?php

use PHPUnit\Framework\TestCase;

require_once "./Model/User.class.php";

class UsuarioTest extends TestCase
{
    private $user;
    private $salvo;

    public function setUp(): void
    {
        $this->user = new Usuario();

        $this->user->setNome("Caio");
        $this->salvo = $this->user->setCpf(60082177054);
    }
    
    public function tearDown(): void
    {
        $this->user = null;
    }

    public function testCpfSucesso()
    {
        $this->assertTrue($this->salvo);
    }

    public function testCpfErro()
    {
        $salvo = $this->user->setCpf(1);

        $this->assertFalse($salvo);
    }

    public function testInstanciaUser()
    {
        $this->assertEquals("Caio", $this->user->getNome());
        $this->assertEquals(60082177054, $this->user->getCpf());
    }
}
