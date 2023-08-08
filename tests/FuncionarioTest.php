<?php

use PHPUnit\Framework\TestCase;

require_once "./Model/Funcionario.class.php";

class FuncionarioTest extends TestCase
{
    private $func;
    private $salvoCpf;
    private $salvoSenha;
    private $salvoEmail;

    public function setUp(): void
    {
        $this->func = new Funcionario();

        $this->func->setNome("Caio");
        $this->salvoCpf = $this->func->setCpf(60082177054);
        $this->salvoSenha = $this->func->setSenha("claro");
        $this->salvoEmail = $this->func->setEmail("caioffnunes04@gmail.com");
        $this->func->setPapel("func");
    }

    public function tearDown(): void
    {
        $this->func = null;
    }
    public function testInstanciaFunc()
    {
        $this->assertEquals(60082177054, $this->func->getCpf());
        $this->assertEquals("Caio", $this->func->getNome());
        $this->assertEquals("claro", $this->func->getSenha());
        $this->assertEquals("caioffnunes04@gmail.com", $this->func->getEmail());
        $this->assertEquals("func", $this->func->getPapel());
    }
    public function testCpfSucesso()
    {
        $this->assertTrue($this->salvoCpf);
    }
    public function testCpfErro()
    {
        $salvo = $this->func->setCpf(1);

        $this->assertFalse($salvo);
    }
    public function testSenhaSucesso()
    {
        $this->assertTrue($this->salvoSenha);
    }
    public function testSenhaErro()
    {
        $salvo = $this->func->setSenha(1);

        $this->assertFalse($salvo);
    }
    public function testEmailSucesso()
    {
        $this->assertTrue($this->salvoEmail);
    }
    public function testEmailErro()
    {
        $salvo = $this->func->setEmail(1);

        $this->assertFalse($salvo);
    }
}
