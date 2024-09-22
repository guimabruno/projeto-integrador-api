<?php
// Este programa é para executar a operação da API
include 'easyStatsService.php'; // Inclui o serviço da sua API

// Cabeçalho para retornar os dados em formato JSON na saída
header("Content-Type: application/json; charset=UTF-8");

// Variável $_GET['url'] é para pegar a URL ou link
if (isset($_GET['url'])) {
    $url = explode('/', $_GET['url']);
    
    if (count($url) > 0 && $url[0] === 'api') {
        array_shift($url);
        
        // Cria o nome da classe de serviço
        $service = ucfirst($url[0]) . 'Service'; 
        array_shift($url);

        $method = strtolower($_SERVER['REQUEST_METHOD']); // Obtém o método HTTP (POST, GET, etc.)

        try {
            // Verifica se a classe do serviço existe
            if (class_exists($service)) {
                $response = call_user_func_array(array(new $service, $method), $url); // Chama o método apropriado
                http_response_code(200);
                echo json_encode(array('status' => 'success', 'data' => $response));
            } else {
                throw new Exception("Serviço não encontrado.");
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
        }
    } else {
        http_response_code(404);
        echo json_encode(array('status' => 'error', 'message' => 'Endpoint não encontrado.'));
    }
}
?>
