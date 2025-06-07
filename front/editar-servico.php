<?php
require_once 'config.php';

// Verificar se está logado
if (!isLoggedIn()) {
    $_SESSION['error'] = 'Você precisa estar logado para editar serviços.';
    redirect('login.php');
}

// Verificar se ID foi fornecido
if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'Serviço não encontrado.';
    redirect('meus-servicos.php');
}

$id = (int)$_GET['id'];
$title = 'Editar Serviço';
$error = '';

// Buscar dados do serviço
$response = makeApiRequest("/servicos/$id");
if (isset($response['error'])) {
    $_SESSION['error'] = 'Serviço não encontrado.';
    redirect('meus-servicos.php');
}

$servico = $response;

// Verificar se o serviço pertence ao usuário (baseado no nome do prestador)
if (stripos($servico['nome_prestador'], $_SESSION['user']['name']) === false) {
    $_SESSION['error'] = 'Você não tem permissão para editar este serviço. Apenas o proprietário pode fazer alterações.';
    redirect('meus-servicos.php');
}

// Processar edição do serviço
if ($_POST) {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $nome_prestador = $_POST['nome_prestador'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    
    if ($nome && $descricao && $nome_prestador && $telefone && $bairro && $cidade) {
        $response = makeApiRequest("/servicos/$id", 'PUT', [
            'nome' => $nome,
            'descricao' => $descricao,
            'nome_prestador' => $nome_prestador,
            'telefone' => $telefone,
            'bairro' => $bairro,
            'cidade' => $cidade
        ], $_SESSION['token']);
        
        if (isset($response['servico']) || (isset($response['message']) && !isset($response['error']))) {
            $_SESSION['success'] = 'Serviço "' . $nome . '" foi atualizado com sucesso! Suas alterações já estão visíveis para outros usuários.';
            redirect('meus-servicos.php');
        } else {
            $errorMsg = $response['message'] ?? 'Erro desconhecido ao atualizar serviço.';
            $error = 'Erro ao atualizar serviço: ' . $errorMsg . ' Tente novamente.';
        }
    } else {
        $error = 'Por favor, preencha todos os campos.';
    }
}

// Usar dados do POST se disponível, senão usar dados originais
$dados = $_POST ?: $servico;

ob_start();
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>
                        Editar Serviço
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
                                       value="<?= e($dados['nome'] ?? '') ?>" required 
                                       placeholder="Ex: Encanador, Eletricista, Diarista...">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nome_prestador" class="form-label">Nome do Prestador *</label>
                                <input type="text" class="form-control" id="nome_prestador" name="nome_prestador" 
                                       value="<?= e($dados['nome_prestador'] ?? '') ?>" required 
                                       placeholder="Seu nome ou nome da empresa">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone/WhatsApp *</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" 
                                       value="<?= e($dados['telefone'] ?? '') ?>" required 
                                       placeholder="(11) 99999-9999">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cidade" class="form-label">Cidade *</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" 
                                       value="<?= e($dados['cidade'] ?? '') ?>" required 
                                       placeholder="Ex: São Paulo">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bairro" class="form-label">Bairro *</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" 
                                   value="<?= e($dados['bairro'] ?? '') ?>" required 
                                   placeholder="Ex: Vila Madalena">
                        </div>

                        <div class="mb-4">
                            <label for="descricao" class="form-label">Descrição do Serviço *</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="4" 
                                      required placeholder="Descreva detalhadamente seu serviço, experiência, valores, horários de atendimento, etc."><?= e($dados['descricao'] ?? '') ?></textarea>
                            <div class="form-text">
                                Seja específico sobre o que você faz. Isso ajuda os clientes a entenderem melhor seu serviço.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-check-circle me-2"></i>
                                Salvar Alterações
                            </button>
                            <a href="meus-servicos.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Voltar para Meus Serviços
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informações do serviço -->
            <div class="mt-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="bi bi-info-circle me-2"></i>
                            Informações do Serviço
                        </h6>
                        <ul class="list-unstyled text-muted small mb-0">
                            <li class="mb-1">
                                <strong>Criado em:</strong> <?= date('d/m/Y H:i', strtotime($servico['created_at'])) ?>
                            </li>
                            <li class="mb-1">
                                <strong>Última atualização:</strong> <?= date('d/m/Y H:i', strtotime($servico['updated_at'])) ?>
                            </li>
                            <li>
                                <strong>ID do serviço:</strong> #<?= $servico['id'] ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Preview do card -->
            <div class="mt-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="bi bi-eye me-2"></i>
                            Preview - Como outros verão seu serviço
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    <i class="bi bi-tools me-2"></i>
                                    <span id="preview-nome"><?= e($servico['nome']) ?></span>
                                </h5>
                                <p class="card-text text-muted" id="preview-descricao">
                                    <?= e(substr($servico['descricao'], 0, 100)) ?>
                                    <?= strlen($servico['descricao']) > 100 ? '...' : '' ?>
                                </p>
                                
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-person-circle me-2 text-primary"></i>
                                        <strong id="preview-prestador"><?= e($servico['nome_prestador']) ?></strong>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-geo-alt me-2 text-primary"></i>
                                        <span id="preview-local"><?= e($servico['bairro']) ?>, <?= e($servico['cidade']) ?></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-telephone me-2 text-primary"></i>
                                        <span id="preview-telefone"><?= e($servico['telefone']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Atualizar preview em tempo real
document.addEventListener('DOMContentLoaded', function() {
    const fields = {
        'nome': 'preview-nome',
        'nome_prestador': 'preview-prestador',
        'telefone': 'preview-telefone',
        'descricao': 'preview-descricao'
    };
    
    for (const [inputId, previewId] of Object.entries(fields)) {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('input', function() {
                const previewEl = document.getElementById(previewId);
                if (previewEl) {
                    if (inputId === 'descricao') {
                        const text = this.value.substring(0, 100);
                        previewEl.textContent = text + (this.value.length > 100 ? '...' : '');
                    } else {
                        previewEl.textContent = this.value;
                    }
                }
            });
        }
    }
    
    // Preview local
    const bairroInput = document.getElementById('bairro');
    const cidadeInput = document.getElementById('cidade');
    const previewLocal = document.getElementById('preview-local');
    
    function updateLocalPreview() {
        const bairro = bairroInput.value || 'Bairro';
        const cidade = cidadeInput.value || 'Cidade';
        previewLocal.textContent = `${bairro}, ${cidade}`;
    }
    
    if (bairroInput && cidadeInput) {
        bairroInput.addEventListener('input', updateLocalPreview);
        cidadeInput.addEventListener('input', updateLocalPreview);
    }
});
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?> 