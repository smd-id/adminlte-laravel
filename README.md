# Installation

## 1. Intall Admin LTE Laravel UI

`composer require jeroennoten/laravel-adminlte`

`php artisan adminlte:install`

`composer require laravel/ui`

`php artisan ui bootstrap --auth`

`php artisan adminlte:install --type=full --with=main_views`

`php artisan adminlte:status`

info [jeroennoten/Laravel-AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE/wiki)

## 2. Install User Roles and Permissions


`composer require spatie/laravel-permission`

`composer require laravelcollective/html`

`php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`

`php artisan migrate`

in app/Models/User.php
```php
...
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
....
```

in app/Http/Kernel.php
```php
....
protected $routeMiddleware = [
    ....
    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
]
....
```

more info [Laravel User Roles and Permissions](https://www.itsolutionstuff.com/post/laravel-8-user-roles-and-permissions-tutorialexample.html)

## 3. Install Laravel Modular

`composer require nwidart/laravel-modules`

`php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"`

in `composer.json`

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "Modules/"
    }
  }
}
```

`composer dump-autoload`

info [Laravel Modular Command](https://nwidart.com/laravel-modules/v6/advanced-tools/artisan-commands)
