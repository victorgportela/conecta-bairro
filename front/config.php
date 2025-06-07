<?php
// Configurações da API
define('API_BASE_URL', 'http://localhost:8000/api');

// Configurações de sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Função para fazer requisições HTTP
function makeApiRequest($endpoint, $method = 'GET', $data = null, $token = null) {
    $url = API_BASE_URL . $endpoint;
    
    $options = [
        'http' => [
            'method' => $method,
            'header' => [
                'Content-Type: application/json',
                'Accept: application/json'
            ]
        ]
    ];
    
    if ($token) {
        $options['http']['header'][] = 'Authorization: Bearer ' . $token;
    }
    
    if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
        $options['http']['content'] = json_encode($data);
    }
    
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    
    if ($response === false) {
        return ['error' => 'Erro na requisição'];
    }
    
    return json_decode($response, true);
}

// Função para verificar se está logado
function isLoggedIn() {
    return isset($_SESSION['user']) && isset($_SESSION['token']);
}

// Função para redirecionar
function redirect($url) {
    header("Location: $url");
    exit;
}

// Função para escapar HTML
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?> 