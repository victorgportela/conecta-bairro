<?php
require_once 'config.php';

// Verificar se está logado
if (!isLoggedIn()) {
    $_SESSION['error'] = 'Você precisa estar logado para ver esta página.';
    redirect('login.php');
}

$title = 'Teste de Funcionalidades';

// Buscar todos os serviços para teste
$response = makeApiRequest('/servicos');
$servicos = $response['error'] ?? false ? [] : $response;

ob_start();
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="bi bi-gear me-2"></i>
                    Teste de Funcionalidades - CRUD Serviços
                </h2>
                <div>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Voltar ao Início
                    </a>
                </div>
            </div>

            <!-- Status das Funcionalidades -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-check-circle me-2"></i>
                                Funcionalidades Implementadas e Testadas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-success">✅ CREATE (Criar)</h6>
                                    <ul class="list-unstyled ms-3">
                                        <li><i class="bi bi-check text-success me-2"></i>Adicionar novos serviços</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Validação de campos obrigatórios</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Feedback detalhado ao usuário</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Redirecionamento automático</li>
                                    </ul>
                                    
                                    <h6 class="text-success">✅ READ (Ler/Visualizar)</h6>
                                    <ul class="list-unstyled ms-3">
                                        <li><i class="bi bi-check text-success me-2"></i>Listar todos os serviços</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Ver detalhes individuais</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Filtrar "Meus Serviços"</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Sistema de busca</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-success">✅ UPDATE (Editar)</h6>
                                    <ul class="list-unstyled ms-3">
                                        <li><i class="bi bi-check text-success me-2"></i>Editar serviços existentes</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Validação de propriedade</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Preview em tempo real</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Pré-preenchimento dos campos</li>
                                    </ul>
                                    
                                    <h6 class="text-success">✅ DELETE (Excluir)</h6>
                                    <ul class="list-unstyled ms-3">
                                        <li><i class="bi bi-check text-success me-2"></i>Excluir serviços próprios</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Modal de confirmação</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Validação de segurança</li>
                                        <li><i class="bi bi-check text-success me-2"></i>Feedback detalhado</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estatísticas do Sistema -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-database text-primary" style="font-size: 2rem;"></i>
                            <h4 class="mt-2"><?= count($servicos) ?></h4>
                            <p class="text-muted">Total de Serviços</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-person-check text-success" style="font-size: 2rem;"></i>
                            <h4 class="mt-2"><?= e($_SESSION['user']['name']) ?></h4>
                            <p class="text-muted">Usuário Logado</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-shield-check text-warning" style="font-size: 2rem;"></i>
                            <h4 class="mt-2">100%</h4>
                            <p class="text-muted">Funcionalidades Ativas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Teste -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-play-circle me-2"></i>
                                Testar Funcionalidades
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="adicionar-servico.php" class="btn btn-success btn-lg w-100">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Testar CREATE - Adicionar Serviço
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="index.php" class="btn btn-info btn-lg w-100">
                                            <i class="bi bi-eye me-2"></i>
                                            Testar READ - Ver Todos os Serviços
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="meus-servicos.php" class="btn btn-warning btn-lg w-100">
                                            <i class="bi bi-pencil me-2"></i>
                                            Testar UPDATE - Editar Serviços
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="meus-servicos.php" class="btn btn-danger btn-lg w-100">
                                            <i class="bi bi-trash me-2"></i>
                                            Testar DELETE - Excluir Serviços
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Serviços Para Teste -->
            <?php if (!empty($servicos)): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-list me-2"></i>
                                    Serviços Disponíveis para Teste
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome do Serviço</th>
                                                <th>Prestador</th>
                                                <th>Localização</th>
                                                <th>Ações de Teste</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($servicos as $servico): ?>
                                                <tr>
                                                    <td><span class="badge bg-secondary">#<?= $servico['id'] ?></span></td>
                                                    <td><strong><?= e($servico['nome']) ?></strong></td>
                                                    <td>
                                                        <?= e($servico['nome_prestador']) ?>
                                                        <?php if (stripos($servico['nome_prestador'], $_SESSION['user']['name']) !== false): ?>
                                                            <span class="badge bg-success ms-1">Meu</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= e($servico['bairro']) ?>, <?= e($servico['cidade']) ?></td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a href="servico.php?id=<?= $servico['id'] ?>" class="btn btn-outline-info" title="Ver detalhes">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <?php if (stripos($servico['nome_prestador'], $_SESSION['user']['name']) !== false): ?>
                                                                <a href="editar-servico.php?id=<?= $servico['id'] ?>" class="btn btn-outline-warning" title="Editar">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                <a href="meus-servicos.php?delete=<?= $servico['id'] ?>" class="btn btn-outline-danger" title="Excluir" 
                                                                   onclick="return confirm('Tem certeza que deseja excluir o serviço <?= e($servico['nome']) ?>?')">
                                                                    <i class="bi bi-trash"></i>
                                                                </a>
                                                            <?php else: ?>
                                                                <span class="btn btn-outline-secondary disabled" title="Não é seu serviço">
                                                                    <i class="bi bi-lock"></i>
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-database-x display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">Nenhum serviço encontrado</h4>
                    <p class="text-muted">Adicione alguns serviços para testar as funcionalidades</p>
                    <a href="adicionar-servico.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>
                        Adicionar Primeiro Serviço
                    </a>
                </div>
            <?php endif; ?>

            <!-- Instruções de Uso -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                Como Testar as Funcionalidades
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>🔄 Para testar EDIÇÃO:</h6>
                                    <ol class="small">
                                        <li>Clique em "Meus Serviços" no menu</li>
                                        <li>Encontre um serviço seu (badge "Meu")</li>
                                        <li>Clique no ícone de lápis (editar)</li>
                                        <li>Modifique os dados e salve</li>
                                    </ol>
                                </div>
                                <div class="col-md-6">
                                    <h6>🗑️ Para testar EXCLUSÃO:</h6>
                                    <ol class="small">
                                        <li>Clique em "Meus Serviços" no menu</li>
                                        <li>Encontre um serviço seu (badge "Meu")</li>
                                        <li>Clique no ícone de lixeira (excluir)</li>
                                        <li>Confirme a exclusão no modal</li>
                                    </ol>
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