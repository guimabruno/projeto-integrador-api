<?php 

require_once 'config.php';

class Partida {
    private $connPdo;

    public function __construct() {
        try {
            $this->connPdo = new PDO(dbDrive . ':host=' . dbHost . ';dbname=' . dbName, dbUser, dbPass);
            $this->connPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }
    }

    public function inserir($idTimeCasa, $idTimeVisitante, $dataPartida, $resultado, $escanteiosCasa = 0, $escanteiosVisitante = 0, $cartoesAmarelosCasa = 0, $cartoesAmarelosVisitante = 0, $cartoesVermelhosCasa = 0, $cartoesVermelhosVisitante = 0, $golsCasa = 0, $golsVisitante = 0, $penalidadeCasa = 0, $penalidadeVisitante = 0, $jogadoresGolsCasa = '', $jogadoresGolsVisitante = '', $jogadoresCartoesAmarelosCasa = '', $jogadoresCartoesAmarelosVisitante = '', $jogadoresCartoesVermelhosCasa = '', $jogadoresCartoesVermelhosVisitante = '') {
        try {
            $sql = "INSERT INTO Partida (idTimeCasa, idTimeVisitante, dataPartida, resultado, escanteiosCasa, escanteiosVisitante, cartoesAmarelosCasa, cartoesAmarelosVisitante, cartoesVermelhosCasa, cartoesVermelhosVisitante, golsCasa, golsVisitante, penalidadeCasa, penalidadeVisitante, jogadoresGolsCasa, jogadoresGolsVisitante, jogadoresCartoesAmarelosCasa, jogadoresCartoesAmarelosVisitante, jogadoresCartoesVermelhosCasa, jogadoresCartoesVermelhosVisitante) 
                    VALUES (:idTimeCasa, :idTimeVisitante, :dataPartida, :resultado, :escanteiosCasa, :escanteiosVisitante, :cartoesAmarelosCasa, :cartoesAmarelosVisitante, :cartoesVermelhosCasa, :cartoesVermelhosVisitante, :golsCasa, :golsVisitante, :penalidadeCasa, :penalidadeVisitante, :jogadoresGolsCasa, :jogadoresGolsVisitante, :jogadoresCartoesAmarelosCasa, :jogadoresCartoesAmarelosVisitante, :jogadoresCartoesVermelhosCasa, :jogadoresCartoesVermelhosVisitante)";
    
            $stmt = $this->connPdo->prepare($sql);
    
            // Bind dos valores
            $stmt->bindValue(':idTimeCasa', $idTimeCasa);
            $stmt->bindValue(':idTimeVisitante', $idTimeVisitante);
            $stmt->bindValue(':dataPartida', $dataPartida);
            $stmt->bindValue(':resultado', $resultado);
            $stmt->bindValue(':escanteiosCasa', $escanteiosCasa);
            $stmt->bindValue(':escanteiosVisitante', $escanteiosVisitante);
            $stmt->bindValue(':cartoesAmarelosCasa', $cartoesAmarelosCasa);
            $stmt->bindValue(':cartoesAmarelosVisitante', $cartoesAmarelosVisitante);
            $stmt->bindValue(':cartoesVermelhosCasa', $cartoesVermelhosCasa);
            $stmt->bindValue(':cartoesVermelhosVisitante', $cartoesVermelhosVisitante);
            $stmt->bindValue(':golsCasa', $golsCasa);
            $stmt->bindValue(':golsVisitante', $golsVisitante);
            $stmt->bindValue(':penalidadeCasa', $penalidadeCasa);
            $stmt->bindValue(':penalidadeVisitante', $penalidadeVisitante);
            $stmt->bindValue(':jogadoresGolsCasa', $jogadoresGolsCasa);
            $stmt->bindValue(':jogadoresGolsVisitante', $jogadoresGolsVisitante);
            $stmt->bindValue(':jogadoresCartoesAmarelosCasa', $jogadoresCartoesAmarelosCasa);
            $stmt->bindValue(':jogadoresCartoesAmarelosVisitante', $jogadoresCartoesAmarelosVisitante);
            $stmt->bindValue(':jogadoresCartoesVermelhosCasa', $jogadoresCartoesVermelhosCasa);
            $stmt->bindValue(':jogadoresCartoesVermelhosVisitante', $jogadoresCartoesVermelhosVisitante);
    
            // Executa a inserção
            $stmt->execute();
    
            echo "Partida inserida com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao inserir partida: " . $e->getMessage();
        }
    }
}
?>
