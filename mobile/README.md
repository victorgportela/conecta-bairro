# Conecta Bairro - App Mobile (Flutter)

## Descrição
App mobile do sistema Conecta Bairro para divulgação de serviços locais. Permite que usuários vejam, busquem e cadastrem serviços na sua comunidade.

## Tecnologias Utilizadas
- **Flutter 3.10+** - Framework mobile
- **Dart 3.0+** - Linguagem de programação
- **Provider** - Gerenciamento de estado
- **HTTP** - Requisições para a API Laravel
- **SharedPreferences** - Armazenamento local
- **URL Launcher** - Abrir links externos

## Funcionalidades

### ✅ Implementadas
- **Autenticação:**
  - Login com email e senha
  - Integração com Laravel Sanctum
  - Persistência de sessão

- **Listagem de Serviços:**
  - Visualização em cards
  - Busca em tempo real
  - Pull-to-refresh
  - Filtros por nome, prestador, cidade, bairro

- **Cadastro de Serviços:**
  - Formulário completo
  - Validações
  - Criação via API

- **Contato Direto:**
  - Botão para ligar
  - Botão para WhatsApp
  - Links automáticos

- **Interface:**
  - Design Material Design
  - Cores consistentes com o sistema
  - Interface intuitiva e responsiva

## Estrutura do Projeto

```
lib/
├── models/
│   ├── user.dart              # Modelo de usuário
│   └── servico.dart           # Modelo de serviço
├── services/
│   ├── api_service.dart       # Comunicação com API
│   └── auth_provider.dart     # Gerenciamento de autenticação
├── screens/
│   ├── auth/
│   │   └── login_screen.dart  # Tela de login
│   └── servicos/
│       ├── home_screen.dart   # Listagem de serviços
│       └── add_servico_screen.dart # Cadastro de serviços
└── main.dart                  # Arquivo principal
```

## Como Executar

### Pré-requisitos
- Flutter SDK 3.10 ou superior
- Dart SDK 3.0 ou superior
- Android Studio ou VS Code
- Emulador Android/iOS ou dispositivo físico

### Instalação

1. **Instale as dependências:**
```bash
flutter pub get
```

2. **Configure a API:**
   - Certifique-se que o servidor Laravel está rodando em `http://localhost:8000`
   - Se necessário, altere a URL base em `lib/services/api_service.dart`

3. **Execute o app:**
```bash
flutter run
```

## Configuração da API

O app está configurado para consumir a API Laravel em:
```
http://localhost:8000/api
```

Para alterar essa configuração, edite o arquivo `lib/services/api_service.dart`:
```dart
static const String baseUrl = 'http://SEU_SERVIDOR:PORTA/api';
```

### Para Testes em Dispositivo Físico

Se você quiser testar em um dispositivo físico, você precisará:

1. **Descobrir seu IP local:**
```bash
# No macOS/Linux
ifconfig | grep "inet "

# No Windows
ipconfig
```

2. **Atualizar a URL da API:**
```dart
static const String baseUrl = 'http://SEU_IP:8000/api';
```

3. **Configurar o Laravel para aceitar conexões externas:**
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## Dados de Teste

Use as mesmas credenciais do sistema web:
- **Email:** joao@example.com
- **Senha:** password

## Funcionalidades Principais

### Tela de Login
- Formulário com validação
- Integração com Laravel Sanctum
- Indicação visual de carregamento
- Exibição de dados de teste

### Tela Principal (Home)
- Lista de serviços em cards
- Barra de busca em tempo real
- Pull-to-refresh para atualizar
- Filtros por diferentes campos
- Botão flutuante para adicionar serviços

### Tela de Cadastro
- Formulário completo com validações
- Campos obrigatórios marcados
- Feedback visual de sucesso/erro
- Interface intuitiva

### Funcionalidades de Contato
- **Ligar:** Abre o discador do telefone
- **WhatsApp:** Abre o WhatsApp Web/App
- Links diretos para facilitar o contato

## Estados do App

O app gerencia os seguintes estados:
- **Carregando:** Tela de loading durante inicialização
- **Não autenticado:** Exibe tela de login
- **Autenticado:** Exibe tela principal

## Tratamento de Erros

- Mensagens de erro amigáveis
- Validação de formulários
- Tratamento de erros de rede
- Feedback visual consistente

## Próximas Melhorias

### Funcionalidades Futuras
- [ ] Registro de novos usuários
- [ ] Edição/exclusão de serviços próprios
- [ ] Sistema de favoritos
- [ ] Notificações push
- [ ] Geolocalização
- [ ] Upload de imagens
- [ ] Sistema de avaliações
- [ ] Chat direto
- [ ] Modo offline

### Melhorias Técnicas
- [ ] Testes unitários
- [ ] Testes de integração
- [ ] CI/CD
- [ ] Tratamento avançado de erros
- [ ] Cache de dados
- [ ] Otimização de performance

## Dependências Principais

```yaml
dependencies:
  flutter: sdk: flutter
  http: ^1.1.0                 # Requisições HTTP
  provider: ^6.1.1             # Gerenciamento de estado
  shared_preferences: ^2.2.2   # Armazenamento local
  json_annotation: ^4.8.1      # Serialização JSON
  url_launcher: ^6.2.2         # Abrir links externos
```

## Comandos Úteis

```bash
# Instalar dependências
flutter pub get

# Executar app
flutter run

# Executar em modo release
flutter run --release

# Limpar cache
flutter clean

# Gerar código para JSON serialization
flutter packages pub run build_runner build

# Verificar problemas
flutter doctor
```

## Suporte

Para problemas técnicos:
1. Verifique se o Flutter está configurado corretamente (`flutter doctor`)
2. Certifique-se que a API Laravel está rodando
3. Verifique a conectividade de rede
4. Consulte os logs do Flutter para erros específicos

## Integração com Backend

O app Flutter consome a API Laravel criada anteriormente:
- Autenticação via Laravel Sanctum
- CRUD de serviços
- Busca e filtros
- Todas as funcionalidades são sincronizadas com o backend 