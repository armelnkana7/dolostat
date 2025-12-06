# Guide des Injections de Dépendances et Authentification Livewire

## Architecture d'Injection de Dépendances

### Service Container

Tous les services sont enregistrés dans le conteneur Laravel via `AppServiceProvider`:

```php
// Dans app/Providers/AppServiceProvider.php
$this->app->singleton(EstablishmentService::class, function ($app) {
    return new EstablishmentService();
});
```

### Services Enregistrés

Les services suivants sont disponibles pour injection:

-   `EstablishmentService`
-   `AcademicYearService`
-   `DepartmentService`
-   `SchoolClassService`
-   `SubjectService`
-   `ProgramService`
-   `UserService`
-   `ReportService`
-   `WeeklyCoverageReportService`

## Utilisation de l'Injection dans Livewire

### Méthode 1: Via `boot()`

Utilisée dans les composants Index pour charger les données initialement:

```php
namespace App\Livewire\Users;

class Index extends Component
{
    public $userService;

    public function boot(UserService $service)
    {
        $this->userService = $service;
    }

    public function render()
    {
        $users = $this->userService->list();
        return view('livewire.users.index', compact('users'));
    }
}
```

### Méthode 2: Via `mount()`

Utilisée quand des paramètres sont passés au composant:

```php
public function mount(UserService $service, $id = null)
{
    $this->service = $service;

    if ($id) {
        $this->user = $service->find($id);
    }
}
```

### Méthode 3: Via les méthodes d'action

Les services peuvent être injectés directement dans les méthodes:

```php
public function save(UserService $service)
{
    // ... validation code ...

    $service->update($this->userId, $validatedData);
}
```

### Méthode 4: Via `app()` (fonction helper)

Alternative si l'injection ne fonctionne pas:

```php
public function boot()
{
    $this->service = app(UserService::class);
}
```

## Authentification Livewire avec Saul Theme

### Pages d'Authentification

#### Login Page

**Routes:**

-   Breeze (Volt): `/login` → `pages.auth.login`
-   Livewire/Saul: `/saul/login` → `auth.saul-login` (alternative)

**Component:** `App\Livewire\Auth\Login`
**View:** `resources/views/livewire/auth/login.blade.php`

#### Register Page

**Routes:**

-   Breeze (Volt): `/register` → `pages.auth.register`
-   Livewire/Saul: `/saul/register` → `auth.saul-register` (alternative)

**Component:** `App\Livewire\Auth\Register`
**View:** `resources/views/livewire/auth/register.blade.php`

### Compatibility avec Breeze

Dolostat coexiste harmonieusement avec Breeze:

-   **Breeze routes** (`/login`, `/register`) utilisent **Volt** (composants Blade)
-   **Saul/Livewire routes** (`/saul/login`, `/saul/register`) utilisent **Livewire** + thème Saul
-   Les deux systèmes partagent la même base de données `users`

**Avantages:**

-   ✅ Flexibilité: choix entre Volt (Breeze) et Livewire (Saul)
-   ✅ Pas de conflit: routes différentes pour chaque système
-   ✅ Progressive enhancement: migrer graduellement vers Livewire si désiré

### Structure du Login Livewire

```php
class Login extends Component
{
    #[Validate('required|email|exists:users,email')]
    public $email = '';

    #[Validate('required|min:6')]
    public $password = '';

    public $rememberMe = false;

    public function login()
    {
        $this->validate();

        if (Auth::attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->rememberMe
        )) {
            session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        $this->addError('password', __('Les identifiants fournis ne correspondent pas...'));
    }
}
```

**Fonctionnalités:**

-   Validation en temps réel via `#[Validate]`
-   Support "Remember Me"
-   Redirection vers `/dashboard` après succès
-   Gestion des erreurs avec `addError()`

### Thème Saul - Assets

Les pages d'authentification Livewire utilisent les assets Saul:

**CSS:**

```html
<link
    href="{{ asset('dist/assets/plugins/global/plugins.bundle.css') }}"
    rel="stylesheet"
/>
<link href="{{ asset('dist/assets/css/style.bundle.css') }}" rel="stylesheet" />
```

**JS:**

```html
<script src="{{ asset('dist/assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('dist/assets/js/scripts.bundle.js') }}"></script>
```

**Livewire Scripts:**

```html
@livewireStyles @livewireScripts
```

## Tests d'Injection de Dépendances

Vérifiez que tous les services sont correctement enregistrés:

```bash
php artisan test tests/Unit/DependencyInjectionTest.php
```

## Tests d'Authentification Livewire

Testez les composants d'authentification:

```bash
php artisan test tests/Feature/Livewire/Auth/LoginComponentTest.php
php artisan test tests/Feature/Livewire/Auth/RegisterComponentTest.php
```

## Checkpoints d'Authentification

### Login Livewire

-   ✅ Page renderée à `/saul/login`
-   ✅ Composant `auth.login` chargé
-   ✅ Email + password requis
-   ✅ Validation email (exists in users)
-   ✅ Validation password (min 6)
-   ✅ Session régénérée après login
-   ✅ Redirection vers `/dashboard`
-   ✅ Support "Remember Me"

### Register Livewire

-   ✅ Page rendue à `/saul/register`
-   ✅ Composant `auth.register` chargé
-   ✅ Name requis (max 255)
-   ✅ Email requis et unique
-   ✅ Password confirma (min 8)
-   ✅ Validation email format
-   ✅ Utilisateur créé avec hash password
-   ✅ Auto-login après inscription
-   ✅ Redirection vers `/dashboard`

## Bonnes Pratiques

### 1. Injection via Type Hints

Toujours utiliser des type hints explicites:

```php
public function boot(UserService $service)  // ✅ BON
```

### 2. Singletons pour les Services

Les services sont singletons - utilisez-les pour partager l'état:

```php
$service1 = app(UserService::class);
$service2 = app(UserService::class);
// $service1 === $service2 // true
```

### 3. Validation avec Attributes

Utilisez les attributes de validation Livewire:

```php
#[Validate('required|email')]
public $email;
```

### 4. Gestion des Erreurs

Utilisez `addError()` pour les erreurs métier:

```php
$this->addError('password', __('Credentials do not match'));
```

### 5. Tests d'Injection

Testez toujours que les services sont correctement injectés:

```php
$service = $this->app->make(UserService::class);
$this->assertInstanceOf(UserService::class, $service);
```

## Troubleshooting

### Erreur: "Class not found"

**Solution:** Vérifiez que la classe de service existe et que l'espace de noms est correct.

### Erreur: "Method not found"

**Solution:** Vérifiez que le service est enregistré dans `AppServiceProvider`.

### Erreur: "Livewire component not found"

**Solution:** Vérifiez le namespace et le chemin de la classe du composant.

### Erreur: "Assets not found" (CSS/JS Saul)

**Solution:** Vérifiez que les assets existent dans `public/dist/assets/` et utilisez `asset()` helper.

## Déploiement

Avant le déploiement, vérifiez:

```bash
# 1. Tester les injections de dépendances
php artisan test tests/Unit/DependencyInjectionTest.php

# 2. Tester l'authentification
php artisan test tests/Feature/Livewire/Auth/

# 3. Vérifier que les assets Saul sont copiés
ls public/dist/assets/

# 4. Regénérer les autoloads
composer dump-autoload -o

# 5. Cache des services
php artisan config:cache
php artisan route:cache
```
