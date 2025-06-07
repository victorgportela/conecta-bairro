<?php
require_once 'config.php';

// Verificar se está logado - se não estiver, redirecionar para login
if (!isLoggedIn()) {
    redirect('login.php');
}

$title = 'Início';

// Buscar serviços
$cidade = $_GET['cidade'] ?? '';
$bairro = $_GET['bairro'] ?? '';
$nome = $_GET['nome'] ?? '';

$endpoint = '/servicos';
$params = [];

if ($cidade) $params['cidade'] = $cidade;
if ($bairro) $params['bairro'] = $bairro;
if ($nome) $params['nome'] = $nome;

if (!empty($params)) {
    $endpoint .= '/search?' . http_build_query($params);
}

$response = makeApiRequest($endpoint);
$servicos = $response['error'] ?? false ? [] : $response;

ob_start();
?>

<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-primary text-white rounded-4 p-5 text-center">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="bi bi-house-heart-fill me-3"></i>
                    Conecta Bairro
                </h1>
                <p class="lead mb-4">
                    Encontre serviços locais em seu bairro ou ofereça seus serviços para a comunidade
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="adicionar-servico.php" class="btn btn-light btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>
                        Adicionar Meu Serviço
                    </a>
                    <a href="meus-servicos.php" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-briefcase me-2"></i>
                        Meus Serviços
                    </a>
                </div>
                <div class="mt-3">
                    <p class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Bem-vindo(a), <strong><?= e($_SESSION['user']['name']) ?></strong>!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros de Busca -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-search me-2"></i>
                        Buscar Serviços
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="nome" class="form-label">Nome do Serviço</label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="<?= e($nome) ?>" placeholder="Ex: Encanador, Eletricista...">
                        </div>
                        <div class="col-md-4">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" 
                                   value="<?= e($cidade) ?>" placeholder="Ex: São Paulo">
                        </div>
                        <div class="col-md-4">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" 
                                   value="<?= e($bairro) ?>" placeholder="Ex: Vila Madalena">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>
                                Buscar
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i>
                                Limpar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Guia para novos usuários -->
    <?php 
    // Verificar se o usuário tem serviços (simulação baseada no nome)
    $userHasServices = false;
    foreach ($servicos as $servico) {
        if (stripos($servico['nome_prestador'], $_SESSION['user']['name']) !== false) {
            $userHasServices = true;
            break;
        }
    }
    ?>
    
    <?php if (!$userHasServices): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="bi bi-lightbulb-fill text-info" style="font-size: 2rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-2">
                                <i class="bi bi-hand-thumbs-up me-2"></i>
                                Primeiro acesso? Vamos começar!
                            </h5>
                            <p class="mb-2">
                                Você ainda não possui serviços cadastrados. Que tal começar adicionando um serviço que você oferece? 
                                Isso ajudará você a se conectar com sua comunidade local.
                            </p>
                            <a href="adicionar-servico.php" class="btn btn-info">
                                <i class="bi bi-plus-circle me-2"></i>
                                Adicionar Meu Primeiro Serviço
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Resultados -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>
                    <i class="bi bi-briefcase me-2"></i>
                    Serviços Disponíveis
                    <span class="badge bg-primary"><?= count($servicos) ?></span>
                </h3>
            </div>

            <?php if (empty($servicos)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-search display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">Nenhum serviço encontrado</h4>
                    <p class="text-muted">Tente ajustar os filtros de busca ou</p>
                    <a href="adicionar-servico.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>
                        Seja o primeiro a adicionar um serviço
                    </a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($servicos as $servico): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <i class="bi bi-tools me-2"></i>
                                        <?= e($servico['nome']) ?>
                                    </h5>
                                    <p class="card-text text-muted">
                                        <?= e(substr($servico['descricao'], 0, 100)) ?>
                                        <?= strlen($servico['descricao']) > 100 ? '...' : '' ?>
                                    </p>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-person-circle me-2 text-primary"></i>
                                            <strong><?= e($servico['nome_prestador']) ?></strong>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-geo-alt me-2 text-primary"></i>
                                            <span><?= e($servico['bairro']) ?>, <?= e($servico['cidade']) ?></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-telephone me-2 text-primary"></i>
                                            <span><?= e($servico['telefone']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-grid gap-2">
                                        <?php 
                                        $whatsappUrl = 'https://wa.me/55' . preg_replace('/[^0-9]/', '', $servico['telefone']);
                                        ?>
                                        <a href="<?= $whatsappUrl ?>" target="_blank" class="btn btn-whatsapp">
                                            <i class="bi bi-whatsapp me-2"></i>
                                            Chamar no WhatsApp
                                        </a>
                                        <a href="servico.php?id=<?= $servico['id'] ?>" class="btn btn-outline-primary">
                                            <i class="bi bi-eye me-2"></i>
                                            Ver Detalhes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?> 