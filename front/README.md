# Conecta Bairro - Frontend Web (PHP)

Site web em PHP para o sistema Conecta Bairro, uma plataforma que conecta prestadores de serviços locais com moradores do bairro.

## 🚀 Funcionalidades

### Para Visitantes
- ✅ Visualizar todos os serviços disponíveis
- ✅ Buscar serviços por nome, cidade e bairro
- ✅ Ver detalhes completos de cada serviço
- ✅ Contato direto via WhatsApp
- ✅ Compartilhamento de serviços
- ✅ Interface responsiva (mobile-friendly)

### Para Usuários Cadastrados
- ✅ Cadastro e login de usuários
- ✅ Adicionar novos serviços
- ✅ Gerenciar "Meus Serviços"
- ✅ Editar serviços existentes
- ✅ Excluir serviços (com confirmação)
- ✅ Dashboard com estatísticas

## 🛠️ Tecnologias Utilizadas

- **PHP 7.4+** - Linguagem de programação
- **Bootstrap 5.3** - Framework CSS responsivo
- **Bootstrap Icons** - Biblioteca de ícones
- **API REST Laravel** - Backend (consumo via HTTP)
- **Session PHP** - Gerenciamento de autenticação
- **JavaScript** - Interações do frontend

## 📁 Estrutura de Arquivos

```
front/
├── config.php              # Configurações da API e funções auxiliares
├── layout.php              # Layout base com navbar e footer
├── index.php               # Página inicial com listagem de serviços
├── login.php               # Página de login
├── register.php            # Página de cadastro
├── logout.php              # Script de logout
├── adicionar-servico.php   # Formulário para adicionar serviços
├── meus-servicos.php       # Listagem de serviços do usuário
├── editar-servico.php      # Formulário para editar serviços
├── servico.php             # Página de detalhes do serviço
├── .htaccess              # Configurações do Apache
└── README.md              # Este arquivo
```

## ⚙️ Configuração

1. **Configure a URL da API** no arquivo `config.php`:
   ```php
   define('API_BASE_URL', 'http://localhost:8000/api');
   ```

2. **Certifique-se que o backend Laravel está rodando** na porta 8000:
   ```bash
   cd back
   php artisan serve
   ```

3. **Configure um servidor web** (Apache/Nginx) ou use o servidor interno do PHP:
   ```bash
   cd front
   php -S localhost:3000
   ```

## 🔐 Sistema de Autenticação

- **Sessões PHP** para manter estado do usuário
- **Bearer Token** para comunicação com a API
- **Logout automático** quando token expira
- **Redirecionamentos inteligentes** baseados no estado de autenticação

## 🎨 Interface e UX

### Design
- **Interface moderna** com Bootstrap 5
- **Cards responsivos** para exibição de serviços
- **Navbar dinâmica** baseada no estado de login
- **Alertas flutuantes** para feedback do usuário
- **Cores consistentes** com a identidade visual

### Funcionalidades UX
- **Busca em tempo real** com filtros múltiplos
- **Preview ao vivo** ao editar serviços
- **Confirmação de exclusão** com modal
- **Botões WhatsApp** com mensagem pré-formatada
- **Breadcrumbs** para navegação
- **Estatísticas visuais** no dashboard

## 📱 Funcionalidades Especiais

### WhatsApp Integration
- **Botão direto** para WhatsApp com número formatado
- **Mensagem pré-definida** contextual
- **Compartilhamento** de serviços via WhatsApp

### Edição e Exclusão
- ✅ **Editar serviços** com preview em tempo real
- ✅ **Excluir serviços** com confirmação de segurança
- ✅ **Validação de propriedade** (apenas o dono pode editar)
- ✅ **Histórico de modificações** com timestamps

### Busca e Filtros
- **Busca por nome** do serviço
- **Filtro por cidade** e bairro
- **Resultados dinâmicos** sem recarregar página
- **Contador de resultados**

## 🔒 Segurança

- **Escape de HTML** em todas as saídas
- **Validação de entrada** nos formulários
- **Headers de segurança** no .htaccess
- **Verificação de permissões** para edição/exclusão
- **Proteção CSRF** através de tokens de sessão

## 🚀 Como Usar

### Para Prestadores de Serviço:
1. Cadastre-se na plataforma
2. Faça login
3. Clique em "Adicionar Serviço"
4. Preencha as informações detalhadas
5. Gerencie seus serviços em "Meus Serviços"

### Para Clientes:
1. Acesse a página inicial
2. Use os filtros para encontrar serviços
3. Clique em "Ver Detalhes" para mais informações
4. Entre em contato via WhatsApp ou telefone

## 🔧 Personalização

### Cores e Tema
Edite as variáveis CSS no `layout.php`:
```css
:root {
    --bs-primary: #1976d2;
    --bs-primary-rgb: 25, 118, 210;
}
```

### URL da API
Configure no `config.php` para diferentes ambientes:
```php
// Desenvolvimento
define('API_BASE_URL', 'http://localhost:8000/api');

// Produção
// define('API_BASE_URL', 'https://api.conectabairro.com/api');
```

## 📋 Requisitos

- **PHP 7.4+** com suporte a sessions
- **Servidor web** (Apache recomendado com mod_rewrite)
- **Backend Laravel** rodando e acessível
- **Conexão com internet** para CDNs do Bootstrap

## 🐛 Solução de Problemas

### Problema: "Erro na requisição"
- Verifique se o backend está rodando
- Confirme a URL da API no config.php
- Verifique se há permissões CORS configuradas

### Problema: "Serviço não encontrado"
- Confirme se o ID do serviço está correto
- Verifique se o serviço não foi excluído

### Problema: Não consegue editar/excluir
- Certifique-se que está logado
- Verifique se o serviço pertence ao usuário atual

## 🌟 Próximas Funcionalidades

- [ ] Upload de imagens para serviços
- [ ] Sistema de avaliações
- [ ] Chat interno da plataforma
- [ ] Notificações por email
- [ ] Integração com mapas
- [ ] Sistema de favoritos

---

**Conecta Bairro** - Conectando vizinhos através de serviços locais 🏘️ 