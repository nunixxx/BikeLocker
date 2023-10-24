<?php
require_once __DIR__ .'/../Utils/autoload.php';
require('tcpdf/tcpdf.php');

class Historico{

        private $locker;
        private $cpf;
        private $cadeado;
        private $chegada;
        private $saida;
        private $bikeId;
    
    public function getLocker() {
        return $this->locker;
    }

    public function setLocker($locker) {
        $this->locker = $locker; 
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function getCadeado() {
        return $this->cadeado;
    }

    public function setCadeado($cadeado) {
        $this->cadeado = $cadeado;
    }

    public function getChegada() {
        return $this->chegada;
    }

    public function setChegada($chegada) {
        $this->chegada = $chegada;
    }

    public function getSaida() {
        return $this->saida;
    }

    public function setSaida($saida) {
        $this->saida = $saida; 
    }

    public function getBikeId() {
        return $this->bikeId;
    }

    public function setBikeId($bikeId) {
        $this->bikeId = $bikeId; 
    }

    public function save()
    {        
        $pdo = Conexao::conexao();
        try {
                
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('INSERT INTO historico (LOCKER, usuario_CPF, CADEADO, CHEGADA, SAIDA, BIKE_ID)
            VALUES (:locker, :cpf, :cadeado, :chegada, :saida, :bikeId)');
            $res = $stmt->execute([
            ':locker' => $this->locker,
            ':cpf' => $this->cpf,
            ':cadeado' => $this->cadeado,
            ':chegada' => $this->chegada,
            ':saida' => $this->saida,    
            ':bikeId' => $this->bikeId
            ]);

            $pdo->commit();

            return $res;
            } catch (PDOException $e) 
            {
                $pdo->rollBack();
                throw $e;
            }
    }

    public static function delete($locker)
    {
        $pdo = Conexao::conexao();
        try {
                
            $pdo->beginTransaction(); 

            $stmt = $pdo->prepare('DELETE FROM historico WHERE LOCKER = :locker');
            $res = $stmt->execute([
                ':locker' => $locker
            ]); 
            $pdo->commit();
            return $res;
        } catch (PDOException $e) 
        {
            $pdo->rollBack();
            throw $e;
        }    
    }
    public static function getAll()
    {
        $pdo = Conexao::conexao();
        $lista = [];
        foreach ($pdo->query("SELECT * FROM historico") as $linha) {
            $historico = new historico();
            $historico->setlocker($linha["LOCKER"]);
            $historico->setCpf($linha["usuario_CPF"]);
            $historico->setCadeado($linha["CADEADO"]);
            $historico->setChegada($linha["CHEGADA"]);
            $historico->setBikeId($linha["Bike_ID"]);

            $lista[] = $historico;
        }
        return $lista;
    }

    public static function createPdf(){

        $pdo = Conexao::conexao();
        $horarioAtual = date('d-m-Y');

        try
        {
        $stmt = $pdo->query("SELECT * FROM HISTORICO");
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdf = new TCPDF();
        $pdf->SetTitle('Historico Bicicletario - ' . $horarioAtual);
        $pdf->AddPage();

        $header = array_keys($result[0]);
        $data = array();
            foreach ($result as $row) {
                $data[] = array_values($row);
            }
        // Cria a tabela
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->MultiCell(0, 10, 'Histórico', 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetFont('helvetica', 'B');
        $pdf->SetFontSize(10);
        $pdf->Table($header, $data);

        $pdf->Output('historico.pdf', 'I');
        }  catch (PDOException $e) {
            die("Erro na consulta SQL: " . $e->getMessage());
        } 
    }

}