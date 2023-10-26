<?php
require_once __DIR__ .'/../Utils/autoload.php';

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
            $historico->setSaida($linha["SAIDA"]);
            $historico->setBikeId($linha["BIKE_ID"]);

            $lista[] = $historico;
        }
        return $lista;
    }

    public static function createPdf(){
        $historicos = Historico::getAll();
        $pdo = Conexao::conexao();
        $horarioAtual = date('d-m-Y');

        try
        {
        $stmt = $pdo->query("SELECT * FROM HISTORICO");
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdf = new tcpdf();
        $pdf->SetTitle('Historico Bicicletario - ' . $horarioAtual);
        $pdf->AddPage();

        $html = '<h1>Historico Bicicletario</h1>';
        $html .= 
        '<table class="cabecalho">
            <thead>
                <tr>
                    <th>Locker</th>
                    <th>Usuário</th>
                    <th>Cadeado</th>
                    <th>Bike</th>
                    <th>Chegada</th>
                    <th>Saida</th>
                </tr>
            </thead>
        </table>
        
        <table>
        <tbody>';
        foreach($historicos as $historico)
        {
            $dataFormat = date("d/m H:i", strtotime($historico->getChegada()));
            $dataFormat1 = date("d/m H:i", strtotime($historico->getSaida()));
        $html .='
            <tr class="item">
              <th>'
                 .$historico->getLocker(). '
              </th>
              <td>'
                .$historico->getCpf().'
              </td>
              <td>'
                .$historico->getCadeado().'
              </td>
              <td>'
                .$historico->getBikeId().'
              </td>
              <td>'
                .$dataFormat.'
              </td>
              <td>'
                .$dataFormat1.'
              </td>
            </tr>';
        }
        $html .='
          </tbody>
        </table>';
        
        $pdf->writeHTML($html);
        ob_end_clean();
        $pdf->Output('Historicos.pdf', 'I');
        }  catch (PDOException $e) {
            die("Erro na consulta SQL: " . $e->getMessage());
        } 
    }

}