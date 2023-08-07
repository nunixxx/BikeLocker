<?php

use PHPUnit\Framework\TestCase;

require_once './DataBase/Conexao.php';

class ConexaoTest extends TestCase{
    public function testConexaoSucesso(){

        global $pdo;

        $this->assertInstanceOf(PDO::class, $pdo);

    }

    public function testConexaoFalha(){

        $pdo;

        // $this->expectException(Exception::class);
        $this->assertNotInstanceOf(PDO::class, $pdo);

    }
}
?>