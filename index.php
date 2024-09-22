<?php
// Este programa é para executar a operação da API
include 'easyStatsService.php'; // Inclui o serviço da sua API

// Cabeçalho para retornar os dados em formato JSON na saída
header("Content-Type: application/json; charset=UTF-8");

// Variável $_GET['url'] é para pegar a URL ou link
if (isset($_GET['url'])) {
    $url = explode('/', $_GET['url']);
    if ($url[0] === 'api') {
        array_shift($url);
        $service = ucfirst($url[0]) . 'Service'; // Cria o nome da classe de serviço
        array_shift($url);

        $method = strtolower($_SERVER['REQUEST_METHOD']); // Obtém o método HTTP (POST, GET, etc.)

        try {
            $response = call_user_func_array(array(new $service, $method), $url); // Chama o método apropriado
            http_response_code(200);
            echo json_encode(array('status' => 'success', 'data' => $response));
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
        }
    }
}
?>
