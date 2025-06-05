// Configuração da API
const API_BASE_URL = 'http://localhost:8000/api';
let authToken = localStorage.getItem('auth_token');
let currentUser = null;

// Inicialização
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se já está logado
    if (authToken) {
        checkAuth();
    }

    // Event listeners
    document.getElementById('loginForm').addEventListener('submit', handleLogin);
    document.getElementById('searchInput').addEventListener('input', handleSearch);
    
    // Auto-complete do modal ao fechar
    document.getElementById('addServicoModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('addServicoForm').reset();
    });
});

// Funções de autenticação
async function handleLogin(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const spinner = document.getElementById('loginSpinner');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    
    spinner.style.display = 'inline-block';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch(`${API_BASE_URL}/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            authToken = data.access_token;
            currentUser = data.user;
            localStorage.setItem('auth_token', authToken);
            
            showMainArea();
            loadServicos();
            showAlert('Login realizado com sucesso!', 'success');
        } else {
            showAlert(data.message || 'Erro no login', 'danger');
        }
    } catch (error) {
        showAlert('Erro de conexão: ' + error.message, 'danger');
    } finally {
        spinner.style.display = 'none';
        submitBtn.disabled = false;
    }
}

async function checkAuth() {
    try {
        const response = await fetch(`${API_BASE_URL}/user`, {
            headers: {
                'Authorization': `Bearer ${authToken}`,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            currentUser = await response.json();
            showMainArea();
            loadServicos();
        } else {
            logout();
        }
    } catch (error) {
        logout();
    }
}

function logout() {
    authToken = null;
    currentUser = null;
    localStorage.removeItem('auth_token');
    showLoginArea();
}

// Funções de interface
function showLoginArea() {
    document.getElementById('loginArea').style.display = 'block';
    document.getElementById('mainArea').style.display = 'none';
    document.getElementById('userInfo').style.display = 'none';
    document.getElementById('logoutBtn').style.display = 'none';
}

function showMainArea() {
    document.getElementById('loginArea').style.display = 'none';
    document.getElementById('mainArea').style.display = 'block';
    document.getElementById('userInfo').style.display = 'block';
    document.getElementById('logoutBtn').style.display = 'block';
    document.getElementById('userInfo').textContent = `Olá, ${currentUser.name}!`;
}

// Funções de serviços
async function loadServicos() {
    const loading = document.getElementById('loading');
    const servicosList = document.getElementById('servicosList');
    const noServicos = document.getElementById('noServicos');
    
    loading.style.display = 'block';
    servicosList.innerHTML = '';
    noServicos.style.display = 'none';
    
    try {
        const response = await fetch(`${API_BASE_URL}/servicos`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            const servicos = await response.json();
            displayServicos(servicos);
        } else {
            showAlert('Erro ao carregar serviços', 'danger');
        }
    } catch (error) {
        showAlert('Erro de conexão: ' + error.message, 'danger');
    } finally {
        loading.style.display = 'none';
    }
}

function displayServicos(servicos) {
    const servicosList = document.getElementById('servicosList');
    const noServicos = document.getElementById('noServicos');
    
    if (servicos.length === 0) {
        noServicos.style.display = 'block';
        return;
    }
    
    servicosList.innerHTML = servicos.map(servico => `
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 servico-card">
                <div class="card-body">
                    <h5 class="card-title text-primary">${servico.nome}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">${servico.nome_prestador}</h6>
                    <p class="card-text">${servico.descricao.substring(0, 100)}${servico.descricao.length > 100 ? '...' : ''}</p>
                    <div class="mb-2">
                        <small class="text-muted">
                            <strong>📞</strong> ${servico.telefone}<br>
                            <strong>📍</strong> ${servico.bairro}, ${servico.cidade}
                        </small>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="tel:${servico.telefone}" class="btn btn-outline-success btn-sm flex-fill">
                            📞 Ligar
                        </a>
                        <a href="https://wa.me/55${servico.telefone.replace(/[^0-9]/g, '')}" 
                           target="_blank" class="btn btn-success btn-sm flex-fill">
                            💬 WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

async function handleSearch() {
    const query = document.getElementById('searchInput').value.trim();
    
    if (query.length === 0) {
        loadServicos();
        return;
    }
    
    if (query.length < 2) return;
    
    try {
        const response = await fetch(`${API_BASE_URL}/servicos/search?nome=${encodeURIComponent(query)}&cidade=${encodeURIComponent(query)}&bairro=${encodeURIComponent(query)}`, {
            headers: {
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            const servicos = await response.json();
            displayServicos(servicos);
        }
    } catch (error) {
        console.error('Erro na busca:', error);
    }
}

async function salvarServico() {
    const form = document.getElementById('addServicoForm');
    const spinner = document.getElementById('saveSpinner');
    const saveBtn = document.querySelector('#addServicoModal .btn-success');
    
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const formData = new FormData(form);
    const data = {
        nome: document.getElementById('nome').value,
        descricao: document.getElementById('descricao').value,
        nome_prestador: document.getElementById('nomePrestador').value,
        telefone: document.getElementById('telefone').value,
        cidade: document.getElementById('cidade').value,
        bairro: document.getElementById('bairro').value
    };
    
    spinner.style.display = 'inline-block';
    saveBtn.disabled = true;
    
    try {
        const response = await fetch(`${API_BASE_URL}/servicos`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${authToken}`
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (response.ok) {
            showAlert('Serviço criado com sucesso!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('addServicoModal')).hide();
            loadServicos();
        } else {
            showAlert(result.message || 'Erro ao criar serviço', 'danger');
        }
    } catch (error) {
        showAlert('Erro de conexão: ' + error.message, 'danger');
    } finally {
        spinner.style.display = 'none';
        saveBtn.disabled = false;
    }
}

// Função auxiliar para mostrar alertas
function showAlert(message, type) {
    const alertContainer = document.createElement('div');
    alertContainer.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertContainer.style.top = '20px';
    alertContainer.style.right = '20px';
    alertContainer.style.zIndex = '9999';
    alertContainer.style.minWidth = '300px';
    
    alertContainer.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertContainer);
    
    setTimeout(() => {
        if (alertContainer.parentNode) {
            alertContainer.remove();
        }
    }, 5000);
} 