<?php
require_once 'easyStats.php'; // Inclua a classe Partida

class EasyStatsService
{
    // Método para inserção de dados
    public function post()
    {
        // Transformar os dados em formato JSON para texto normal
        $dados = json_decode(file_get_contents('php://input'), true);

        // Verificar se os dados foram recebidos
        if ($dados == null) {
            throw new Exception("Faltaram informações para incluir a partida!");
        }

        // Instanciar a classe Partida
        $partida = new Partida();

        // Chamar o método de inserção e capturar a resposta (se necessário)
        $partida->inserir(
            $dados['idTimeCasa'],
            $dados['idTimeVisitante'],
            $dados['dataPartida'],
            $dados['resultado'],
            $dados['escanteiosCasa'] ?? 0,
            $dados['escanteiosVisitante'] ?? 0,
            $dados['cartoesAmarelosCasa'] ?? 0,
            $dados['cartoesAmarelosVisitante'] ?? 0,
            $dados['cartoesVermelhosCasa'] ?? 0,
            $dados['cartoesVermelhosVisitante'] ?? 0,
            $dados['golsCasa'] ?? 0,
            $dados['golsVisitante'] ?? 0,
            $dados['penalidadeCasa'] ?? 0,
            $dados['penalidadeVisitante'] ?? 0,
            $dados['jogadoresGolsCasa'] ?? '',
            $dados['jogadoresGolsVisitante'] ?? '',
            $dados['jogadoresCartoesAmarelosCasa'] ?? '',
            $dados['jogadoresCartoesAmarelosVisitante'] ?? '',
            $dados['jogadoresCartoesVermelhosCasa'] ?? '',
            $dados['jogadoresCartoesVermelhosVisitante'] ?? ''
        );

        // Retornar dados adicionais, se necessário
        return [
            'message' => "Partida inserida com sucesso!",
            'dados' => $dados // ou você pode retornar mais informações, como um ID gerado
        ];
    }

    // Um método (serviço) para consulta de dados
    public function get($idTime = null)
    {
        if ($idTime) { // se existe id, chama a operação: select($id)
            return time::select($idTime); // Corrigido para usar 'time' minúsculo
        } else { // se não existe id, chame a operação: selectAll()
            return time::selectAll(); // Corrigido para usar 'time' minúsculo
        }
    }
}
