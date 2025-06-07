<?php
require_once 'config.php';

// Verificar se está logado
if (!isLoggedIn()) {
    $_SESSION['error'] = 'Você precisa estar logado para ver os detalhes dos serviços.';
    redirect('login.php');
}

// Verificar se ID foi fornecido
if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'Serviço não encontrado.';
    redirect('index.php');
}

$id = (int)$_GET['id'];

// Buscar dados do serviço
$response = makeApiRequest("/servicos/$id");
if (isset($response['error'])) {
    $_SESSION['error'] = 'Serviço não encontrado.';
    redirect('index.php');
}

$servico = $response;
$title = $servico['nome'];

ob_start();
?>

<div class="container">
    <div class="row">
        <!-- Breadcrumb -->
        <div class="col-12 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Início</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= e($servico['nome']) ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Detalhes do Serviço -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-tools me-3"></i>
                        <?= e($servico['nome']) ?>
                    </h1>
                </div>
                <div class="card-body p-4">
                    <!-- Informações do Prestador -->
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px;">
                                <i class="bi bi-person-circle fs-2"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1"><?= e($servico['nome_prestador']) ?></h5>
                            <p class="text-muted mb-0">Prestador de Serviços</p>
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            Sobre o Serviço
                        </h5>
                        <p class="lead"><?= nl2br(e($servico['descricao'])) ?></p>
                    </div>

                    <!-- Informações de Localização -->
                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="bi bi-geo-alt me-2"></i>
                            Localização
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-building me-2 text-primary"></i>
                                    <strong>Cidade:</strong>
                                    <span class="ms-2"><?= e($servico['cidade']) ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-map me-2 text-primary"></i>
                                    <strong>Bairro:</strong>
                                    <span class="ms-2"><?= e($servico['bairro']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações Adicionais -->
                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="bi bi-calendar me-2"></i>
                            Informações Adicionais
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar-plus me-2 text-success"></i>
                                    <strong>Cadastrado em:</strong>
                                    <span class="ms-2"><?= date('d/m/Y', strtotime($servico['created_at'])) ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar-check me-2 text-info"></i>
                                    <strong>Atualizado em:</strong>
                                    <span class="ms-2"><?= date('d/m/Y', strtotime($servico['updated_at'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar com Contato -->
        <div class="col-lg-4">
            <!-- Card de Contato -->
            <div class="card shadow sticky-top" style="top: 20px;">
                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-0">
                        <i class="bi bi-telephone me-2"></i>
                        Entre em Contato
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-telephone-fill text-success" style="font-size: 2rem;"></i>
                        <h6 class="mt-2 mb-1">Telefone</h6>
                        <p class="h5 text-dark"><?= e($servico['telefone']) ?></p>
                    </div>

                    <div class="d-grid gap-2">
                        <?php 
                        $whatsappUrl = 'https://wa.me/55' . preg_replace('/[^0-9]/', '', $servico['telefone']);
                        $whatsappMessage = "Olá! Vi seu anúncio de " . $servico['nome'] . " no Conecta Bairro e gostaria de saber mais informações.";
                        $whatsappUrlWithMessage = $whatsappUrl . "?text=" . urlencode($whatsappMessage);
                        ?>
                        <a href="<?= $whatsappUrlWithMessage ?>" target="_blank" class="btn btn-whatsapp btn-lg">
                            <i class="bi bi-whatsapp me-2"></i>
                            Chamar no WhatsApp
                        </a>
                        <a href="tel:<?= e($servico['telefone']) ?>" class="btn btn-outline-primary">
                            <i class="bi bi-telephone me-2"></i>
                            Ligar Agora
                        </a>
                    </div>
                </div>
            </div>

            <!-- Dicas de Segurança -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>
                        Dicas de Segurança
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled text-muted small mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Sempre peça referências e portfólio
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Combine preços antes do serviço
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Prefira pagamentos após a conclusão
                        </li>
                        <li>
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Mantenha contato através do WhatsApp
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Compartilhar -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-share me-2"></i>
                        Compartilhar
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <?php
                        $currentUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        $shareText = "Encontrei este serviço no Conecta Bairro: " . $servico['nome'] . " por " . $servico['nome_prestador'];
                        ?>
                        <button class="btn btn-outline-primary btn-sm" onclick="compartilharWhatsApp()">
                            <i class="bi bi-whatsapp me-2"></i>
                            Compartilhar no WhatsApp
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="copiarLink()">
                            <i class="bi bi-link me-2"></i>
                            Copiar Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botão Voltar -->
    <div class="row mt-4">
        <div class="col-12">
            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar
            </a>
        </div>
    </div>
</div>

<script>
function compartilharWhatsApp() {
    const texto = "<?= addslashes($shareText) ?>";
    const url = "<?= addslashes($currentUrl) ?>";
    const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(texto + "\n\n" + url)}`;
    window.open(whatsappUrl, '_blank');
}

function copiarLink() {
    const url = "<?= addslashes($currentUrl) ?>";
    navigator.clipboard.writeText(url).then(function() {
        // Mostrar feedback
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check me-2"></i>Link Copiado!';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?> 