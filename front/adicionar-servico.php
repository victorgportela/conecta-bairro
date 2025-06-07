<?php
require_once 'config.php';

// Verificar se está logado
if (!isLoggedIn()) {
    $_SESSION['error'] = 'Você precisa estar logado para adicionar serviços.';
    redirect('login.php');
}

$title = 'Adicionar Serviço';
$error = '';

// Processar adição de serviço
if ($_POST) {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $nome_prestador = $_POST['nome_prestador'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    
    if ($nome && $descricao && $nome_prestador && $telefone && $bairro && $cidade) {
        $response = makeApiRequest('/servicos', 'POST', [
            'nome' => $nome,
            'descricao' => $descricao,
            'nome_prestador' => $nome_prestador,
            'telefone' => $telefone,
            'bairro' => $bairro,
            'cidade' => $cidade
        ], $_SESSION['token']);
        
        if (isset($response['servico'])) {
            $_SESSION['success'] = 'Serviço "' . $nome . '" foi adicionado com sucesso! Agora ele está visível para todos os usuários da plataforma.';
            redirect('meus-servicos.php');
        } else {
            $errorMsg = $response['message'] ?? 'Erro desconhecido ao adicionar serviço.';
            $error = 'Erro ao adicionar serviço: ' . $errorMsg . ' Verifique os dados e tente novamente.';
        }
    } else {
        $error = 'Por favor, preencha todos os campos.';
    }
}

ob_start();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>
                        Adicionar Novo Serviço
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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome" class="form-label">Nome do Serviço *</label>
                                <input type="text" class="form-control" id="nome" name="nome" 
                                       value="<?= e($_POST['nome'] ?? '') ?>" required 
                                       placeholder="Ex: Encanador, Eletricista, Diarista...">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nome_prestador" class="form-label">Nome do Prestador *</label>
                                <input type="text" class="form-control" id="nome_prestador" name="nome_prestador" 
                                       value="<?= e($_POST['nome_prestador'] ?? '') ?>" required 
                                       placeholder="Seu nome ou nome da empresa">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone/WhatsApp *</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" 
                                       value="<?= e($_POST['telefone'] ?? '') ?>" required 
                                       placeholder="(11) 99999-9999">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cidade" class="form-label">Cidade *</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" 
                                       value="<?= e($_POST['cidade'] ?? '') ?>" required 
                                       placeholder="Ex: São Paulo">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bairro" class="form-label">Bairro *</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" 
                                   value="<?= e($_POST['bairro'] ?? '') ?>" required 
                                   placeholder="Ex: Vila Madalena">
                        </div>

                        <div class="mb-4">
                            <label for="descricao" class="form-label">Descrição do Serviço *</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4" 
                                      required placeholder="Descreva detalhadamente seu serviço, experiência, valores, horários de atendimento, etc."><?= e($_POST['descricao'] ?? '') ?></textarea>
                            <div class="form-text">
                                Seja específico sobre o que você faz. Isso ajuda os clientes a entenderem melhor seu serviço.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>
                                Adicionar Serviço
                            </button>
                            <a href="meus-servicos.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Voltar para Meus Serviços
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Dicas -->
            <div class="mt-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="bi bi-lightbulb me-2"></i>
                            Dicas para um bom anúncio
                        </h6>
                        <ul class="list-unstyled text-muted small mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Seja específico:</strong> Detalhe exatamente que tipo de serviço você oferece
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Mencione sua experiência:</strong> Quantos anos você trabalha na área?
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Inclua informações práticas:</strong> Horários, formas de pagamento, valores aproximados
                            </li>
                            <li>
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Use um número atualizado:</strong> Certifique-se que o telefone está correto para contato
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