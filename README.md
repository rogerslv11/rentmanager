# RentManager

Sistema de gestão de aluguel de imóveis construído com Laravel 13, Livewire 4 e Tailwind CSS 4.

## Stack

- **Backend:** Laravel 13.17 (PHP 8.3)
- **Frontend:** Livewire 4 + Alpine.js + Tailwind CSS 4 (via Vite 8)
- **Auth & Permissões:** Laravel Sanctum + Spatie Laravel Permission
- **Banco:** SQLite (padrão) ou MySQL
- **PDF:** barryvdh/laravel-dompdf

## Funcionalidades

- **Imóveis, Proprietários e Inquilinos** com cadastro completo e fotos
- **Contratos** com fluxo de criação, renovação e histórico
- **Financeiro:** cobranças, pagamentos, repasses a proprietários e despesas
- **Manutenção:** solicitações, categorias, prioridades, cotações e fotos
- **Vistorias** com itens e fotos
- **Seguros** com tipos e vigência
- **Fornecedores (vendors)** e **Documentos** (stub)
- **Portal do Inquilino** e **Portal do Proprietário** (rotas segregadas por papel)
- **Página pública de imóvel** (sem autenticação, com slug)
- **Calendário**, **Relatórios**, **Notificações**
- **Multi-organização** com contexto por `organization_id`
- **Multi-idioma:** pt-BR (default) e en

## Papéis

`Admin`, `OrganizationOwner`, `PropertyManager`, `Financial`, `Maintenance`, `Agent`, `Owner`, `Tenant` — gerenciados via Spatie Permission.

## Requisitos

- PHP 8.3+
- Composer 2
- Node 20+
- SQLite ou MySQL

## Instalação

```bash
git clone https://github.com/rogerslv11/rentmanager.git
cd rentmanager
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Acesse `http://localhost:8000`.

### Credenciais de demonstração (após `migrate --seed`)

- **Admin demo:** `demo@rentmanager.test` / `password`
- **Admin padrão:** `admin@rentmanager.test` / `password`

## Testes

```bash
php artisan test
```

Cobre serviços de pagamento, cálculo de repasses, marcação de cobranças em atraso e contexto de inquilino.

## Estrutura relevante

```
app/
  Actions/         # Ações de domínio
  Console/         # Comandos artisan
  Enums/           # 14 enums de domínio
  Events/          # Eventos do app
  Http/            # Middleware, requests
  Jobs/
  Livewire/        # ~30 componentes (Auth, Properties, Financial, ...)
  Models/          # 27 models Eloquent
  Notifications/
  Policies/
  Services/        # PaymentService, PayoutCalculation, ...
  Support/
database/
  factories/       # Factories para todos os models
  migrations/      # Migrations numeradas e versionadas
  seeders/         # RolePermissionSeeder, DemoDataSeeder, DatabaseSeeder
resources/
  views/           # Blade (layouts, partials, pages)
routes/
  web.php          # Rotas web (Livewire-based)
  api.php          # API
tests/                   # Feature + Unit
```

## Configuração

Edite `.env` conforme seu ambiente. Principais chaves:

- `RENTMANAGER_DEMO_EMAIL` / `RENTMANAGER_DEMO_PASSWORD`
- `RENTMANAGER_DEFAULT_ADMIN_EMAIL` / `RENTMANAGER_DEFAULT_ADMIN_PASSWORD`
- `RENTMANAGER_STORAGE_DISK` (default `public`)
- Gateways de pagamento (mock): `ASAAS_API_KEY`, `MERCADOPAGO_ACCESS_TOKEN`, `STRIPE_KEY`/`STRIPE_SECRET`

## Licença

MIT.