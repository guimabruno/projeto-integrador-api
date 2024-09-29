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

    public function deletar($idPartida) {
        try {
            // Começa uma transação
            $this->connPdo->beginTransaction();
    
            // Seleciona a partida para obter as informações de gols e cartões
            $sql = "SELECT * FROM Partida WHERE idPartida = :idPartida";
            $stmt = $this->connPdo->prepare($sql);
            $stmt->bindValue(':idPartida', $idPartida);
            $stmt->execute();
            $partida = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($partida) {
                // Reverte os gols e cartões dos times
                $this->atualizarTimes($partida['idTimeCasa'], -$partida['golsCasa'], -$partida['cartoesAmarelosCasa'], -$partida['cartoesVermelhosCasa']);
                $this->atualizarTimes($partida['idTimeVisitante'], -$partida['golsVisitante'], -$partida['cartoesAmarelosVisitante'], -$partida['cartoesVermelhosVisitante']);
    
                // Reverte os dados dos jogadores
                $this->atualizarJogadores($partida['jogadoresGolsCasa'], 'golsAcumulados', -$partida['golsCasa']);
                $this->atualizarJogadores($partida['jogadoresGolsVisitante'], 'golsAcumulados', -$partida['golsVisitante']);
                $this->atualizarJogadores($partida['jogadoresCartoesAmarelosCasa'], 'cartoesAmarelosAcumulados', -$partida['cartoesAmarelosCasa']);
                $this->atualizarJogadores($partida['jogadoresCartoesAmarelosVisitante'], 'cartoesAmarelosAcumulados', -$partida['cartoesAmarelosVisitante']);
                $this->atualizarJogadores($partida['jogadoresCartoesVermelhosCasa'], 'cartoesVermelhosAcumulados', -$partida['cartoesVermelhosCasa']);
                $this->atualizarJogadores($partida['jogadoresCartoesVermelhosVisitante'], 'cartoesVermelhosAcumulados', -$partida['cartoesVermelhosVisitante']);
    
                // Exclui a partida
                $sqlDelete = "DELETE FROM Partida WHERE idPartida = :idPartida";
                $stmtDelete = $this->connPdo->prepare($sqlDelete);
                $stmtDelete->bindValue(':idPartida', $idPartida);
                $stmtDelete->execute();
    
                // Confirma a transação
                $this->connPdo->commit();
    
                return [
                    'message' => "Partida deletada com sucesso!",
                    'idPartida' => $idPartida
                ];
            } else {
                // Alterado: retornar erro como um valor em vez de echo
                throw new Exception("Partida não encontrada.");
            }
        } catch (PDOException $e) {
            
            $this->connPdo->rollBack();
            
            throw new Exception("Erro ao deletar partida: " . $e->getMessage());
        }
    }
    

    
}

class Time {
    public static function select(int $id) {
        $tabela = "times";
        $coluna = "idTime";
        $connPdo = new PDO(dbDrive . ':host=' . dbHost . '; dbname=' . dbName, dbUser, dbPass);

        // Seleciona o time
        $stmt = $connPdo->prepare("SELECT * FROM $tabela WHERE $coluna = :idTime");
        $stmt->bindValue(':idTime', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $time = $stmt->fetch(PDO::FETCH_ASSOC); // Armazena os dados do time

            // Adiciona os jogadores do time
            $time['jogadores'] = self::selectJogadores($id); // Chama a nova função para buscar jogadores
            
            // Adiciona as partidas do time
            $time['partidas'] = self::selectPartidas($id); // Chama a nova função para buscar partidas
            
            return $time; // Retorna o time com jogadores e partidas
        } else {
            throw new Exception("Sem registro do time");
        }
    }

    public static function selectAll() {
        $tabela = "times";
        $connPdo = new PDO(dbDrive . ':host=' . dbHost . '; dbname=' . dbName, dbUser, dbPass);

        $sql = "SELECT * FROM $tabela";
        $stmt = $connPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os registros
        } else {
            throw new Exception("Nenhum registro encontrado");
        }
    }

    // Função para selecionar jogadores do time
    private static function selectJogadores(int $idTime) {
        $tabela = "jogadores"; // Nome da tabela de jogadores
        $connPdo = new PDO(dbDrive . ':host=' . dbHost . '; dbname=' . dbName, dbUser, dbPass);

        $stmt = $connPdo->prepare("SELECT * FROM $tabela WHERE idTime = :idTime");
        $stmt->bindValue(':idTime', $idTime);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os jogadores do time
        } else {
            return []; // Retorna um array vazio se não houver jogadores
        }
    }

    // Função para selecionar partidas do time
    private static function selectPartidas(int $idTime) {
        $tabela = "partida"; // Nome da tabela de partidas
        $connPdo = new PDO(dbDrive . ':host=' . dbHost . '; dbname=' . dbName, dbUser, dbPass);

        $stmt = $connPdo->prepare("SELECT * FROM $tabela WHERE idTimeCasa = :idTime OR idTimeVisitante = :idTime");
        $stmt->bindValue(':idTime', $idTime);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todas as partidas do time
        } else {
            return []; // Retorna um array vazio se não houver partidas
        }
    }
}


    
?>
