<?php
require_once 'config.php';

// Verificar se está logado
if (!isLoggedIn()) {
    $_SESSION['error'] = 'Você precisa estar logado para ver seus serviços.';
    redirect('login.php');
}

$title = 'Meus Serviços';

// Processar exclusão de serviço
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    
    // Primeiro, verificar se o serviço existe e pertence ao usuário
    $servicoResponse = makeApiRequest("/servicos/$id");
    
    if (isset($servicoResponse['error'])) {
        $_SESSION['error'] = 'Serviço não encontrado ou já foi excluído.';
        redirect('meus-servicos.php');
    }
    
    // Verificar se o serviço pertence ao usuário atual
    if (stripos($servicoResponse['nome_prestador'], $_SESSION['user']['name']) === false) {
        $_SESSION['error'] = 'Você não tem permissão para excluir este serviço.';
        redirect('meus-servicos.php');
    }
    
    // Proceder com a exclusão
    $response = makeApiRequest("/servicos/$id", 'DELETE', null, $_SESSION['token']);
    
    if (isset($response['message']) && !isset($response['error'])) {
        $_SESSION['success'] = 'Serviço "' . $servicoResponse['nome'] . '" foi excluído com sucesso!';
    } else {
        $errorMsg = $response['message'] ?? 'Erro desconhecido ao excluir serviço.';
        $_SESSION['error'] = 'Erro ao excluir serviço: ' . $errorMsg;
    }
    redirect('meus-servicos.php');
}

// Buscar todos os serviços (como não temos filtro por usuário na API, vamos simular)
$response = makeApiRequest('/servicos');
$todosServicos = $response['error'] ?? false ? [] : $response;

// Filtrar serviços do usuário atual baseado no nome do prestador
// Nota: Esta é uma solução temporária. Idealmente, a API deveria ter um endpoint para servicos do usuário
$meusServicos = [];
foreach ($todosServicos as $servico) {
    // Verificar se o nome do prestador corresponde ao usuário logado
    if (stripos($servico['nome_prestador'], $_SESSION['user']['name']) !== false) {
        $meusServicos[] = $servico;
    }
}

ob_start();
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="bi bi-briefcase me-2"></i>
                    Meus Serviços
                    <span class="badge bg-primary"><?= count($meusServicos) ?></span>
                </h2>
                <a href="adicionar-servico.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    Adicionar Serviço
                </a>
            </div>

            <?php if (empty($meusServicos)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-briefcase display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">Você ainda não possui serviços cadastrados</h4>
                    <p class="text-muted">Comece adicionando seu primeiro serviço e conecte-se com sua comunidade!</p>
                    <a href="adicionar-servico.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>
                        Adicionar Primeiro Serviço
                    </a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($meusServicos as $servico): ?>
                        <div class="col-lg-6">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0 text-primary">
                                        <i class="bi bi-tools me-2"></i>
                                        <?= e($servico['nome']) ?>
                                    </h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="editar-servico.php?id=<?= $servico['id'] ?>">
                                                    <i class="bi bi-pencil me-2"></i>
                                                    Editar
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" 
                                                   onclick="confirmarExclusao(<?= $servico['id'] ?>, '<?= e($servico['nome']) ?>')">
                                                    <i class="bi bi-trash me-2"></i>
                                                    Excluir
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-muted">
                                        <?= e(substr($servico['descricao'], 0, 150)) ?>
                                        <?= strlen($servico['descricao']) > 150 ? '...' : '' ?>
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
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-telephone me-2 text-primary"></i>
                                            <span><?= e($servico['telefone']) ?></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar me-2 text-primary"></i>
                                            <small class="text-muted">
                                                Cadastrado em <?= date('d/m/Y', strtotime($servico['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex gap-2">
                                        <a href="servico.php?id=<?= $servico['id'] ?>" class="btn btn-outline-primary flex-fill">
                                            <i class="bi bi-eye me-2"></i>
                                            Ver Detalhes
                                        </a>
                                        <a href="editar-servico.php?id=<?= $servico['id'] ?>" class="btn btn-warning" title="Editar serviço">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" title="Excluir serviço"
                                                onclick="confirmarExclusao(<?= $servico['id'] ?>, '<?= e($servico['nome']) ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Estatísticas -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="card-title">
                                    <i class="bi bi-graph-up me-2"></i>
                                    Estatísticas
                                </h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="h5 text-primary"><?= count($meusServicos) ?></div>
                                        <div class="text-muted small">Serviços Ativos</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="h5 text-success">
                                            <?= count(array_unique(array_column($meusServicos, 'cidade'))) ?>
                                        </div>
                                        <div class="text-muted small">Cidades Atendidas</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="h5 text-info">
                                            <?= count(array_unique(array_column($meusServicos, 'bairro'))) ?>
                                        </div>
                                        <div class="text-muted small">Bairros Atendidos</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="modalExclusao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o serviço <strong id="nomeServicoExclusao"></strong>?</p>
                <p class="text-muted small">Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-2"></i>
                    Cancelar
                </button>
                <a href="#" id="linkExclusao" class="btn btn-danger">
                    <i class="bi bi-trash me-2"></i>
                    Excluir
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarExclusao(id, nome) {
    document.getElementById('nomeServicoExclusao').textContent = nome;
    document.getElementById('linkExclusao').href = '?delete=' + id;
    new bootstrap.Modal(document.getElementById('modalExclusao')).show();
}
</script>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?> 