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
            // Inserindo a partida
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

            // Atualiza os times
            $this->atualizarTimes($idTimeCasa, $golsCasa, $cartoesAmarelosCasa, $cartoesVermelhosCasa);
            $this->atualizarTimes($idTimeVisitante, $golsVisitante, $cartoesAmarelosVisitante, $cartoesVermelhosVisitante);

            // Atualiza os jogadores
            $this->atualizarJogadores($jogadoresGolsCasa, 'golsAcumulados', $golsCasa);
            $this->atualizarJogadores($jogadoresCartoesAmarelosCasa, 'cartoesAmarelosAcumulados', $cartoesAmarelosCasa);
            $this->atualizarJogadores($jogadoresCartoesVermelhosCasa, 'cartoesVermelhosAcumulados', $cartoesVermelhosCasa);
            $this->atualizarJogadores($jogadoresGolsVisitante, 'golsAcumulados', $golsVisitante);
            $this->atualizarJogadores($jogadoresCartoesAmarelosVisitante, 'cartoesAmarelosAcumulados', $cartoesAmarelosVisitante);
            $this->atualizarJogadores($jogadoresCartoesVermelhosVisitante, 'cartoesVermelhosAcumulados', $cartoesVermelhosVisitante);

            echo "Partida inserida com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao inserir partida: " . $e->getMessage();
        }
    }

    private function atualizarTimes($idTime, $gols, $cartoesAmarelos, $cartoesVermelhos) {
        $sql = "UPDATE Times SET golsAcumulados = golsAcumulados + :gols, cartoesAmarelosAcumulados = cartoesAmarelosAcumulados + :cartoesAmarelos, cartoesVermelhosAcumulados = cartoesVermelhosAcumulados + :cartoesVermelhos WHERE idTime = :idTime";
        $stmt = $this->connPdo->prepare($sql);
        $stmt->bindValue(':gols', $gols);
        $stmt->bindValue(':cartoesAmarelos', $cartoesAmarelos);
        $stmt->bindValue(':cartoesVermelhos', $cartoesVermelhos);
        $stmt->bindValue(':idTime', $idTime);
        $stmt->execute();
    }

    private function atualizarJogadores($idsJogadores, $campo, $valor) {
        if ($idsJogadores) {
            $ids = explode(',', $idsJogadores);
            foreach ($ids as $id) {
                $sql = "UPDATE Jogadores SET $campo = $campo + :valor WHERE idJogador = :idJogador";
                $stmt = $this->connPdo->prepare($sql);
                $stmt->bindValue(':valor', $valor);
                $stmt->bindValue(':idJogador', intval($id));
                $stmt->execute();
            }
        }
    }
}

    class Time {

        public static function select (int $id) {
            $tabela ="times";
            $coluna ="idTime";
            $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);

            $stmt = $connPdo->prepare("SELECT * FROM $tabela WHERE $coluna = :idTime");
            $stmt->bindValue(':idTime', $id); // Corrigido o bindValue para corresponder ao parâmetro na consulta
            $stmt->execute();

            if ($stmt->rowCount() > 0) { 
                return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados se existir
            } else {
                throw new Exception("Sem registro do time");
            }
        } // Aqui estava faltando o fechamento da função select()

        public static function selectAll() {
            $tabela = "times";
            $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);

            $sql = "SELECT * FROM $tabela";
            $stmt = $connPdo->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os registros
            } else {
                throw new Exception("Nenhum registro encontrado");
            }
        }
    }

    
?>
