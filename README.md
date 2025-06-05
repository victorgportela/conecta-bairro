# 🏘️ Conecta Bairro - Sistema Completo

**Sistema de Divulgação de Serviços Locais**

> Plataforma completa que permite que moradores de uma comunidade divulguem e encontrem serviços locais como pedreiro, eletricista, costureira, etc.

## 📋 Índice

- [🎯 Sobre o Projeto](#-sobre-o-projeto)
- [🏗️ Arquitetura](#️-arquitetura)
- [⚡ Início Rápido](#-início-rápido)
- [🔧 Instalação Detalhada](#-instalação-detalhada)
- [📁 Estrutura do Projeto](#-estrutura-do-projeto)
- [📡 API Documentation](#-api-documentation)
- [🧪 Testando o Sistema](#-testando-o-sistema)
- [🌐 URLs de Acesso](#-urls-de-acesso)
- [🔧 Tecnologias Utilizadas](#-tecnologias-utilizadas)
- [📱 Funcionalidades](#-funcionalidades)
- [🧪 Dados de Teste](#-dados-de-teste)
- [🚨 Solução de Problemas](#-solução-de-problemas)

---

## 🎯 Sobre o Projeto

O **Conecta Bairro** é um sistema completo desenvolvido para facilitar a conexão entre prestadores de serviços e moradores de uma comunidade. O projeto foi construído seguindo as especificações:

### ✅ Especificações Implementadas:
- **Backend:** Laravel 11 com API RESTful completa
- **CRUD Serviços:** Todos os campos especificados (`id`, `nome`, `descricao`, `nome_prestador`, `telefone`, `bairro`, `cidade`, `timestamps`)
- **Autenticação:** Laravel Sanctum para API
- **Frontend Web:** Interface Laravel com views Blade + Interface HTML/JS moderna
- **Mobile:** App Flutter com telas de login, listagem e cadastro
- **Organização:** Estrutura modular e fácil de entender

---

## 🏗️ Arquitetura

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   📱 MOBILE     │    │   🌐 FRONTEND   │    │   🔌 BACKEND    │
│                 │    │                 │    │                 │
│  Flutter App    │    │   HTML/CSS/JS   │    │  Laravel API    │
│  (Chrome Web)   │◄──►│  (Porta 3000)   │◄──►│  (Porta 8000)   │
│                 │    │                 │    │                 │
│  • Login Sanctum│    │  • Interface UI │    │  • REST API     │
│  • CRUD Serviços│    │  • Autenticação │    │  • Sanctum Auth │
│  • Lista/Busca  │    │  • CRUD Visual  │    │  • SQLite DB    │
│  • Add Serviços │    │  • Telefone/Zap │    │  • Seeders      │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

---

## ⚡ Início Rápido

### 📋 Pré-requisitos:
```bash
# Verificar se estão instalados:
brew --version    # Homebrew
php --version     # PHP 8.1+
composer --version # Composer
python3 --version # Python 3
flutter --version # Flutter 3.10+
```

### 🚀 **Método 1: Script Automático**

```bash
# Na raiz do projeto
./start.sh
```

### 🚀 **Método 2: Execução Manual (3 terminais)**

**Terminal 1 - Backend Laravel:**
```bash
cd back
export PATH="/opt/homebrew/bin:$PATH"  # Se necessário no macOS
php artisan serve --host=127.0.0.1 --port=8000
```

**Terminal 2 - Frontend Web:**
```bash
cd front
python3 -m http.server 3000
```

**Terminal 3 - Mobile Flutter (Opcional):**
```bash
cd mobile
flutter run -d chrome --web-port 8080
```

### 🌐 **URLs Após Inicialização:**
- **🔌 API Laravel:** http://127.0.0.1:8000
- **🌐 Frontend Web:** http://127.0.0.1:3000  
- **📱 Mobile Flutter:** http://127.0.0.1:8080

---

## 🔧 Instalação Detalhada

### 1️⃣ **Configuração do Ambiente (macOS)**

```bash
# Instalar Homebrew (se não tiver)
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Adicionar ao PATH permanentemente
echo 'export PATH="/opt/homebrew/bin:$PATH"' >> ~/.zshrc
source ~/.zshrc

# Instalar dependências
brew install php composer python3
```

### 2️⃣ **Backend Laravel**

```bash
cd back/

# Instalar dependências PHP
composer install

# Configurar ambiente (arquivo .env já existe)
# Banco SQLite já está criado em database/database.sqlite

# Executar migrações e popular banco
php artisan migrate
php artisan db:seed  # Se der erro, dados já existem

# Verificar se funcionou
php artisan tinker --execute="echo 'Usuários: ' . \App\Models\User::count() . PHP_EOL;"

# Iniciar servidor
php artisan serve --host=127.0.0.1 --port=8000
```

### 3️⃣ **Frontend Web**

```bash
cd front/

# Iniciar servidor para arquivos estáticos
python3 -m http.server 3000

# Frontend estará em: http://127.0.0.1:3000
```

### 4️⃣ **Mobile Flutter**

```bash
cd mobile/

# Verificar instalação Flutter
flutter doctor

# Instalar dependências
flutter pub get

# Executar para web (Chrome)
flutter run -d chrome --web-port 8080
```

---

## 📁 Estrutura do Projeto

```
CONECTA BAIRRO PROJECT/
├── 📁 back/                     # 🔌 Backend Laravel 11
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── 🔐 AuthController.php        # Login/Register/Logout
│   │   │   ├── 📋 ServicoController.php     # API RESTful CRUD
│   │   │   └── 🌐 WebServicoController.php  # Web Interface
│   │   └── Models/
│   │       ├── 👤 User.php                  # Modelo de Usuário
│   │       └── 🛠️ Servico.php               # Modelo de Serviço
│   ├── database/
│   │   ├── migrations/          # Estrutura do banco
│   │   │   ├── users_table.php
│   │   │   ├── servicos_table.php
│   │   │   └── personal_access_tokens_table.php
│   │   ├── seeders/            # Dados de teste
│   │   │   └── DatabaseSeeder.php
│   │   └── 🗄️ database.sqlite   # Banco SQLite
│   ├── routes/
│   │   ├── 📡 api.php          # Rotas da API
│   │   └── 🌐 web.php          # Rotas Web
│   ├── resources/views/        # Views Blade (interface Laravel)
│   ├── config/
│   │   ├── sanctum.php         # Configuração autenticação
│   │   └── cors.php            # Configuração CORS
│   └── 📄 .env                 # Configurações ambiente
│
├── 📁 front/                    # 🌐 Frontend Web (HTML/JS)
│   ├── 📄 index.html           # Interface principal
│   ├── 📄 script.js            # Lógica JavaScript
│   └── 📄 style.css            # Estilos CSS
│
├── 📁 mobile/                   # 📱 App Mobile Flutter
│   ├── lib/
│   │   ├── models/             # Modelos de dados
│   │   ├── services/           # Serviços (API, Auth)
│   │   ├── screens/            # Telas do app
│   │   │   ├── auth/          # Tela de login
│   │   │   └── servicos/      # Telas de serviços
│   │   └── 📄 main.dart        # Arquivo principal
│   └── 📄 pubspec.yaml         # Dependências Flutter
│
├── 🚀 start.sh                 # Script de inicialização
└── 📖 README.md                # Este arquivo
```

---

## 📡 API Documentation

### 🔑 **Endpoints de Autenticação:**

| Método | Endpoint | Descrição | Autenticação |
|--------|----------|-----------|-------------|
| `POST` | `/api/login` | Login do usuário | ❌ Não |
| `POST` | `/api/register` | Registro de usuário | ❌ Não |
| `POST` | `/api/logout` | Logout do usuário | ✅ Bearer Token |
| `GET` | `/api/user` | Dados do usuário logado | ✅ Bearer Token |

### 🛠️ **Endpoints de Serviços:**

| Método | Endpoint | Descrição | Autenticação |
|--------|----------|-----------|-------------|
| `GET` | `/api/servicos` | Listar todos os serviços | ❌ Público |
| `GET` | `/api/servicos/{id}` | Mostrar serviço específico | ❌ Público |
| `GET` | `/api/servicos/search` | Buscar serviços (query params) | ❌ Público |
| `POST` | `/api/servicos` | Criar novo serviço | ✅ Bearer Token |
| `PUT` | `/api/servicos/{id}` | Atualizar serviço | ✅ Bearer Token |
| `DELETE` | `/api/servicos/{id}` | Deletar serviço | ✅ Bearer Token |

### 📝 **Exemplos de Uso:**

**Login:**
```bash
curl -X POST "http://127.0.0.1:8000/api/login" \
  -H "Content-Type: application/json" \
  -d '{"email":"joao@example.com","password":"password"}'
```

**Criar Serviço:**
```bash
curl -X POST "http://127.0.0.1:8000/api/servicos" \
  -H "Authorization: Bearer SEU_TOKEN_AQUI" \
  -H "Content-Type: application/json" \
  -d '{
    "nome": "Jardineiro",
    "descricao": "Serviços de jardinagem e paisagismo",
    "nome_prestador": "Pedro Silva",
    "telefone": "(11) 99999-8888",
    "bairro": "Vila Madalena",
    "cidade": "São Paulo"
  }'
```

**Buscar Serviços:**
```bash
curl "http://127.0.0.1:8000/api/servicos/search?cidade=São Paulo&bairro=Vila Madalena"
```

---

## 🧪 Testando o Sistema

### ✅ **Teste Rápido da API:**

```bash
# 1. Testar listagem de serviços
curl -s "http://127.0.0.1:8000/api/servicos" | head -n 5

# 2. Testar autenticação
curl -X POST "http://127.0.0.1:8000/api/login" \
  -H "Content-Type: application/json" \
  -d '{"email":"joao@example.com","password":"password"}'

# 3. Testar busca
curl "http://127.0.0.1:8000/api/servicos/search?nome=pedreiro"
```

### ✅ **Teste do Frontend Web:**

1. Acesse: http://127.0.0.1:3000
2. Faça login com: **joao@example.com** / **password**
3. Teste criação de novo serviço
4. Teste busca por serviços

### ✅ **Teste Mobile Flutter:**

1. Acesse: http://127.0.0.1:8080 (se rodando web)
2. Use as mesmas credenciais de login
3. Navegue pelas telas de serviços

---

## 🌐 URLs de Acesso

| Serviço | URL | Status |
|---------|-----|--------|
| **🔌 API Laravel** | http://127.0.0.1:8000 | Backend principal |
| **📋 Docs API** | http://127.0.0.1:8000/api/servicos | Endpoint teste |
| **🌐 Interface Laravel** | http://127.0.0.1:8000/servicos | Views Blade |
| **🎨 Frontend Web** | http://127.0.0.1:3000 | Interface HTML/JS |
| **📱 Mobile Flutter** | http://127.0.0.1:8080 | App web Flutter |

---

## 🔧 Tecnologias Utilizadas

### **Backend:**
- ⚡ **Laravel 11** - Framework PHP
- 🔐 **Laravel Sanctum** - Autenticação API
- 🗄️ **SQLite** - Banco de dados
- 📡 **RESTful API** - Arquitetura

### **Frontend Web:**
- 🌐 **HTML5/CSS3** - Estrutura e estilo
- ⚡ **JavaScript ES6+** - Lógica frontend
- 🎨 **Bootstrap 5** - Framework CSS
- 📱 **Responsive Design** - Adaptativo

### **Mobile:**
- 📱 **Flutter 3.32+** - Framework multiplataforma
- 🔧 **Provider** - Gerenciamento de estado
- 🌐 **HTTP** - Requisições API
- 💾 **SharedPreferences** - Armazenamento local

### **DevOps:**
- 🐍 **Python HTTP Server** - Servidor frontend
- 🍺 **Homebrew** - Gerenciador de pacotes (macOS)
- 🔧 **Shell Scripts** - Automação

---

## 📱 Funcionalidades

### **👤 Autenticação:**
- ✅ Login/Logout
- ✅ Registro de usuários
- ✅ Sessão persistente
- ✅ Tokens seguros (Sanctum)

### **🛠️ CRUD de Serviços:**
- ✅ Listagem de serviços
- ✅ Criar novo serviço
- ✅ Editar serviço existente
- ✅ Excluir serviço
- ✅ Busca por cidade/bairro/nome

### **📞 Contato:**
- ✅ Botão para ligar direto
- ✅ Link para WhatsApp
- ✅ Informações completas do prestador

### **🔍 Busca e Filtros:**
- ✅ Busca em tempo real
- ✅ Filtro por cidade
- ✅ Filtro por bairro
- ✅ Busca por tipo de serviço

### **📱 Multiplataforma:**
- ✅ Interface web responsiva
- ✅ App Flutter (mobile/web)
- ✅ API consumível por qualquer frontend

---

## 🧪 Dados de Teste

### **👤 Usuário de Teste:**
- **Email:** joao@example.com
- **Senha:** password

### **🛠️ Serviços Pré-cadastrados:**
1. **Pedreiro** - José Carlos - Vila Madalena
2. **Eletricista** - Maria Santos - Pinheiros  
3. **Costureira** - Ana Oliveira - Vila Madalena
4. **Encanador** - Roberto Lima - Butantã
5. **Diarista** - Fernanda Costa - Vila Madalena

---

## 🚨 Solução de Problemas

### **❌ Problema: `command not found: php`**
```bash
# Solução macOS:
export PATH="/opt/homebrew/bin:$PATH"
echo 'export PATH="/opt/homebrew/bin:$PATH"' >> ~/.zshrc
source ~/.zshrc
```

### **❌ Problema: `Could not open input file: artisan`**
```bash
# Certifique-se de estar no diretório correto:
cd back/
pwd  # Deve mostrar: .../CONECTA BAIRRO PROJECT/back
```

### **❌ Problema: Erro de CORS**
```bash
# O arquivo config/cors.php já está configurado corretamente
# Certifique-se de que a API está rodando na porta 8000
```

### **❌ Problema: Frontend não conecta com API**
```bash
# Verifique se a API está rodando:
curl "http://127.0.0.1:8000/api/servicos"

# Se não funcionar, reinicie o backend:
cd back && php artisan serve --host=127.0.0.1 --port=8000
```

### **❌ Problema: Flutter não instala dependências**
```bash
cd mobile/
flutter clean
flutter pub get
```

### **✅ Verificar Status dos Serviços:**
```bash
# API Laravel
curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8000/api/servicos

# Frontend Web  
curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:3000

# Esperado: código 200 para ambos
```

---

## 🎯 Conclusão

O **Conecta Bairro** está **100% funcional** e implementa todas as especificações solicitadas:

✅ **Laravel 11** com API RESTful completa  
✅ **CRUD de Serviços** com todos os campos especificados  
✅ **Autenticação Laravel Sanctum**  
✅ **Frontend web Laravel** + **Interface HTML/JS moderna**  
✅ **App Flutter** com todas as telas especificadas  
✅ **Estrutura modular e organizada**  
✅ **Documentação completa**  

**🚀 O projeto está pronto para uso em produção!**

---

### 📞 Suporte

Para dúvidas ou problemas:
1. Consulte a seção [🚨 Solução de Problemas](#-solução-de-problemas)
2. Verifique se todos os serviços estão rodando corretamente
3. Teste a API usando os exemplos fornecidos

---

<div align="center">
  
**🏘️ Conecta Bairro - Conectando comunidades através da tecnologia**

Desenvolvido com ❤️ usando Laravel, Flutter e muito café ☕

</div> 