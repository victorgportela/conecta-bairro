<?php
require_once 'config.php';

// Fazer logout na API se tiver token
if (isset($_SESSION['token'])) {
    makeApiRequest('/logout', 'POST', null, $_SESSION['token']);
}

// Limpar sessão
session_destroy();

// Redirecionar para home com mensagem
session_start();
$_SESSION['success'] = 'Logout realizado com sucesso!';
redirect('index.php');
?> 