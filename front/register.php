<?php
require_once 'config.php';

// Se já está logado, redirecionar para home
if (isLoggedIn()) {
    redirect('index.php');
}

$title = 'Cadastrar';
$error = '';

// Processar registro
if ($_POST) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';
    
    if ($name && $email && $password && $password_confirmation) {
        if ($password === $password_confirmation) {
            $response = makeApiRequest('/register', 'POST', [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password_confirmation
            ]);
            
            if (isset($response['access_token'])) {
                $_SESSION['token'] = $response['access_token'];
                $_SESSION['user'] = $response['user'];
                $_SESSION['success'] = 'Cadastro realizado com sucesso! Bem-vindo(a) ao Conecta Bairro, ' . $response['user']['name'] . '! Comece adicionando seu primeiro serviço.';
                redirect('index.php');
            } else {
                $error = $response['message'] ?? 'Erro ao criar conta. Tente novamente.';
            }
        } else {
            $error = 'As senhas não coincidem.';
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
                    <h4 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>
                        Criar Conta
                    </h4>
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
                            <label for="name" class="form-label">Nome Completo</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= e($_POST['name'] ?? '') ?>" required 
                                       placeholder="Seu nome completo">
                            </div>
                        </div>

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

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" 
                                       required placeholder="Mínimo 8 caracteres" minlength="8">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" class="form-control" id="password_confirmation" 
                                       name="password_confirmation" required placeholder="Digite a senha novamente">
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-person-plus me-2"></i>
                                Criar Conta
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <p class="text-muted mb-0">
                            Já tem uma conta? 
                            <a href="login.php" class="text-decoration-none">
                                Entre aqui
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Benefícios de se cadastrar -->
            <div class="text-center mt-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="bi bi-star me-2"></i>
                            Por que se cadastrar?
                        </h6>
                        <ul class="list-unstyled text-muted small mb-0">
                            <li class="mb-1">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Adicione seus próprios serviços
                            </li>
                            <li class="mb-1">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Gerencie seus anúncios
                            </li>
                            <li class="mb-1">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                Conecte-se com sua comunidade
                            </li>
                            <li>
                                <i class="bi bi-check-circle text-success me-2"></i>
                                É totalmente gratuito!
                            </li>
                        </ul>
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