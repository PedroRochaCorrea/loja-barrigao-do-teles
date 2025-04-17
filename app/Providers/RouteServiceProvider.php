<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    /**
     * Define as rotas para o aplicativo.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Define a rota de redirecionamento após login, com base no papel do usuário.
     */
    public static function redirectTo(): string
    {
        $user = Auth::user();

        if (!$user) {
            return '/login';
        }

        switch ($user->role) {
            case 'admin':
                return '/admin/dashboard';
            case 'vendedor':
                return '/vendedor/dashboard';
            case 'cliente':
                return '/cliente/dashboard';
            default:
                return '/login';
        }
    }
}
