<?php
require_once 'config.php';

// Se já está logado, redirecionar para home
if (isLoggedIn()) {
    redirect('index.php');
}

$title = 'Entrar';
$error = '';

// Processar login
if ($_POST) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($email && $password) {
        $response = makeApiRequest('/login', 'POST', [
            'email' => $email,
            'password' => $password
        ]);
        
        if (isset($response['access_token'])) {
            $_SESSION['token'] = $response['access_token'];
            $_SESSION['user'] = $response['user'];
            $_SESSION['success'] = 'Bem-vindo(a) ao Conecta Bairro, ' . $response['user']['name'] . '! Agora você pode adicionar seus serviços e encontrar prestadores locais.';
            redirect('index.php');
        } else {
            $error = $response['message'] ?? 'Erro ao fazer login. Verifique suas credenciais.';
        }
    } else {
        $error = 'Por favor, preencha todos os campos.';
    }
}

ob_start();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <div class="mb-2">
                        <i class="bi bi-house-heart-fill" style="font-size: 2rem;"></i>
                    </div>
                    <h4 class="mb-0">Conecta Bairro</h4>
                    <p class="mb-0 small">Entre para acessar a plataforma</p>
                </div>
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <?= e($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= e($_POST['email'] ?? '') ?>" required 
                                       placeholder="seu@email.com">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" 
                                       required placeholder="Sua senha">
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Entrar
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <p class="text-muted mb-0">
                            Não tem uma conta? 
                            <a href="register.php" class="text-decoration-none">
                                Cadastre-se aqui
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Informações adicionais -->
            <div class="text-center mt-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="bi bi-info-circle me-2"></i>
                            Bem-vindo ao Conecta Bairro
                        </h6>
                        <p class="card-text text-muted small mb-3">
                            Sua plataforma para conectar-se com prestadores de serviços locais e oferecer seus próprios serviços para a comunidade.
                        </p>
                        <div class="row text-start">
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <small>Encontre serviços locais</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <small>Contato direto via WhatsApp</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <small>Ofereça seus serviços</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <small>Totalmente gratuito</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?> 