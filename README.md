# AlgiaAnalysis

Plataforma web para coleta de dados médicos de pacientes com fibromialgia, desenvolvida com a TALL Stack.

## 📋 Sobre o Projeto

AlgiaAnalysis é um sistema de gestão de pacientes desenvolvido para auxiliar no acompanhamento médico de pessoas diagnosticadas com fibromialgia. A plataforma permite:

- **Questionários Diários**: Acompanhamento diário da condição do paciente
- **Questionários FIQR**: Avaliação periódica do impacto da fibromialgia na qualidade de vida
- **Consultas Médicas**: Registro e acompanhamento de consultas
- **Análises e Relatórios**: Visualização de dados e análises geradas por IA
- **Dashboard Interativo**: Visualização de gráficos e métricas de saúde

## 🛠 Stack Tecnológica

Este projeto utiliza a **TALL Stack**:

- **T**ailwind CSS - Framework CSS utilitário
- **A**lpine.js - Framework JavaScript minimalista
- **L**aravel - Framework PHP
- **L**ivewire - Framework para interfaces reativas

### Dependências Principais

- **TallStackUI** - Único pacote de terceiros, fornece componentes UI prontos para uso

## 📦 Pré-requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

- **PHP** (versão 8.1 ou superior recomendada)
- **Composer** - Gerenciador de dependências PHP
- **Node.js** e **npm** - Para gerenciar assets frontend
- **MySQL** ou **SQLite** - Banco de dados

## 🚀 Instalação

Siga os passos abaixo para configurar o ambiente de desenvolvimento:

### 1. Clone o repositório

```bash
git clone <url-do-repositorio>
cd fibromialgia
```

### 2. Instale as dependências PHP

```bash
composer install
```

### 3. Instale as dependências Node.js

```bash
npm install
```

### 4. Configure o arquivo .env

Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

Edite o arquivo `.env` e configure as seguintes variáveis:

```env
APP_NAME="AlgiaAnalysis"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# Ou configure MySQL se preferir
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=fibromialgia
# DB_USERNAME=root
# DB_PASSWORD=

# Gemini API (para análises de IA)
GEMINI_API_KEY=your_api_key_here
```

### 5. Gere a chave da aplicação

```bash
php artisan key:generate
```

### 6. Configure o banco de dados

Se estiver usando SQLite, crie o arquivo de banco:

```bash
touch database/database.sqlite
```

Se estiver usando MySQL, crie o banco de dados e execute as migrations:

```bash
php artisan migrate
```

### 7. Seed do banco de dados (opcional)

Para popular o banco com dados de exemplo:

```bash
php artisan db:seed
```

## ▶️ Como Executar

O projeto requer dois processos rodando simultaneamente:

### Terminal 1 - Servidor PHP

```bash
php artisan serve
```

O servidor estará disponível em: `http://localhost:8000`

### Terminal 2 - Assets Frontend

```bash
npm run dev
```

Este comando compila os assets CSS e JavaScript em modo de desenvolvimento com hot-reload.

> **Nota:** Mantenha ambos os terminais abertos durante o desenvolvimento.

## 📁 Estrutura do Projeto

```
fibromialgia/
├── app/
│   ├── Http/
│   │   └── Controllers/     # Controladores HTTP
│   ├── Livewire/            # Componentes Livewire
│   │   ├── Admin/           # Componentes do Admin
│   │   ├── Auth/            # Autenticação
│   │   ├── Doctor/          # Área do Médico
│   │   └── Patient/         # Área do Paciente
│   ├── Models/              # Modelos Eloquent
│   └── Services/             # Serviços (ex: GeminiService)
├── resources/
│   ├── views/
│   │   ├── components/      # Componentes Blade
│   │   └── livewire/        # Views dos componentes Livewire
│   ├── css/                 # Arquivos CSS
│   └── js/                  # Arquivos JavaScript
├── routes/
│   ├── web.php              # Rotas web principais
│   ├── doctor.php           # Rotas do médico
│   └── patient.php          # Rotas do paciente
└── database/
    ├── migrations/           # Migrations do banco de dados
    └── seeders/              # Seeders
```

## 👥 Usuários do Sistema

### Paciente
- Cadastro e gerenciamento de questionários diários
- Preenchimento de questionários FIQR
- Registro de consultas médicas
- Visualização de relatórios e análises

### Médico
- Gestão de pacientes vinculados
- Visualização de questionários e consultas
- Geração de análises comparativas com IA
- Prescrição de medicamentos

## 🔧 Comandos Úteis

### Desenvolvimento
```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recompilar assets
npm run build

# Executar testes
php artisan test
```

### Banco de Dados
```bash
# Criar nova migration
php artisan make:migration create_table_name

# Executar migrations
php artisan migrate

# Rollback
php artisan migrate:rollback
```

## 🌐 Variáveis de Ambiente Importantes

Certifique-se de configurar estas variáveis no arquivo `.env`:

- `APP_KEY` - Chave de criptografia da aplicação
- `DB_CONNECTION` - Tipo de banco de dados (sqlite, mysql)
- `GEMINI_API_KEY` - Chave da API do Gemini para análises de IA

## 📝 Licença

Este projeto é privado e destinado a uso interno.

## 👨‍💻 Desenvolvimento

Para mais informações sobre desenvolvimento ou suporte, entre em contato com a equipe de desenvolvimento.

---

**Desenvolvido com ❤️ usando TALL Stack**
