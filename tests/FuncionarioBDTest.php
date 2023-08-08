<?php

use PHPUnit\Framework\TestCase;

require_once "./Model/Funcionario.class.php";

class FuncionarioBDTest extends TestCase
{
    private $func;
    private $salvo;

    public function setUp(): void
    {
        $this->func = new Funcionario();

        $this->func->setNome("Caio");
        $this->func->setCpf(60082177054);
        $this->func->setSenha("claro");
        $this->func->setEmail("Caioffnunes04@gmail.com");
        $this->func->setPapel("func");

        $this->salvo = $this->func->save();
    }

    public function tearDown(): void
    {
        $deletado = $this->func->delete($this->func->getCpf());

        $this->assertTrue($deletado);
    }

    public function testSaveFunc()
    {
        $this->assertTrue($this->salvo);
    }

    public function testUpdateFunc()
    {
        $func = $this->func;

        $this->func->setNome("Jose");
        $this->func->setSenha("claro1");
        $atualizado = $this->func->update();

        $this->assertTrue($atualizado);

        $this->assertEquals($this->func->getCpf(), $func->getCpf());
        $this->assertEquals($this->func->getNome(), $func->getNome());
        $this->assertEquals($this->func->getSenha(), $func->getSenha());
        $this->assertEquals($this->func->getEmail(), $func->getEmail());
        $this->assertEquals($this->func->getPapel(), $func->getPapel());
    }

    public function testLoadFunc()
    {
        $func = new Funcionario();

        $func->setCpf(60082177054);
        $func->load();

        $this->assertEquals($this->func->getCpf(), $func->getCpf());
        $this->assertEquals($this->func->getNome(), $func->getNome());
        $this->assertEquals($this->func->getSenha(), $func->getSenha());
        $this->assertEquals($this->func->getEmail(), $func->getEmail());
        $this->assertEquals($this->func->getPapel(), $func->getPapel());
    }
}
