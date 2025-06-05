# Conecta Bairro - Sistema de Divulgação de Serviços Locais

## Descrição
O Conecta Bairro é um sistema que permite que moradores de uma comunidade divulguem seus serviços locais, facilitando a conexão entre prestadores de serviços e clientes na vizinhança.

## Tecnologias Utilizadas
- **Laravel 11** - Framework PHP para o backend
- **Laravel Sanctum** - Autenticação API
- **SQLite** - Banco de dados
- **Bootstrap 5** - Interface web responsiva
- **Blade** - Sistema de templates

## Funcionalidades

### Backend (API + Web)
- ✅ CRUD completo de serviços
- ✅ Autenticação via Laravel Sanctum
- ✅ API RESTful para consumo mobile
- ✅ Interface web com Laravel Blade
- ✅ Busca e filtros por cidade/bairro
- ✅ Validações e tratamento de erros

### Campos do Serviço
- Nome do serviço (ex: Pedreiro, Eletricista)
- Descrição detalhada
- Nome do prestador
- Telefone de contato
- Bairro e cidade
- Data de criação/atualização

## Como Executar o Projeto

### Pré-requisitos
- PHP 8.1 ou superior
- Composer
- SQLite (já incluído no PHP)

### Instalação

1. **Clone/baixe o projeto:**
```bash
cd conecta-bairro
```

2. **Instale as dependências:**
```bash
composer install
```

3. **Configure o ambiente:**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Execute as migrações e seeders:**
```bash
php artisan migrate --seed
```

5. **Inicie o servidor:**
```bash
php artisan serve
```

6. **Acesse a aplicação:**
- **Interface Web:** http://localhost:8000
- **API:** http://localhost:8000/api

## Rotas da API

### Autenticação
- `POST /api/register` - Registrar usuário
- `POST /api/login` - Login
- `POST /api/logout` - Logout (autenticado)
- `GET /api/user` - Dados do usuário (autenticado)

### Serviços
- `GET /api/servicos` - Listar todos os serviços
- `GET /api/servicos/{id}` - Detalhes de um serviço
- `GET /api/servicos/search` - Buscar serviços
- `POST /api/servicos` - Criar serviço (autenticado)
- `PUT /api/servicos/{id}` - Atualizar serviço (autenticado)
- `DELETE /api/servicos/{id}` - Excluir serviço (autenticado)

### Parâmetros de Busca
- `?cidade=São Paulo` - Filtrar por cidade
- `?bairro=Vila Madalena` - Filtrar por bairro
- `?nome=Pedreiro` - Filtrar por nome do serviço

## Exemplos de Uso da API

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "joao@example.com", "password": "password"}'
```

### Listar Serviços
```bash
curl http://localhost:8000/api/servicos
```

### Criar Serviço (com token)
```bash
curl -X POST http://localhost:8000/api/servicos \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -d '{
    "nome": "Jardineiro",
    "descricao": "Manutenção de jardins e plantas",
    "nome_prestador": "Carlos Silva",
    "telefone": "(11) 99999-0000",
    "bairro": "Vila Madalena",
    "cidade": "São Paulo"
  }'
```

## Interface Web

A interface web está disponível em `http://localhost:8000` e oferece:
- Listagem de serviços em cards responsivos
- Formulários para criar/editar serviços
- Página de detalhes com informações completas
- Botões para contato direto (telefone/WhatsApp)
- Design limpo com Bootstrap 5

## Dados de Teste

O sistema inclui dados de exemplo:
- **Usuário:** joao@example.com (senha: password)
- **Serviços:** Pedreiro, Eletricista, Costureira, Encanador, Diarista

## Estrutura do Projeto

```
conecta-bairro/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── ServicoController.php
│   │   └── WebServicoController.php
│   └── Models/
│       ├── User.php
│       └── Servico.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── layouts/app.blade.php
│   └── servicos/
├── routes/
│   ├── api.php
│   └── web.php
└── config/
```

## Próximos Passos

Este projeto serve como base para:
1. Implementação do app mobile Flutter
2. Adição de recursos como avaliações
3. Sistema de notificações
4. Geolocalização
5. Upload de imagens dos serviços

## Suporte

Para dúvidas ou problemas, verifique:
1. Se o PHP e Composer estão instalados
2. Se as permissões de arquivo estão corretas
3. Se o banco SQLite foi criado corretamente
4. Logs em `storage/logs/laravel.log` 