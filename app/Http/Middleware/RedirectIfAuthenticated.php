<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            $current = $request->path(); // exemplo: "register", "login", etc.

            switch ($role) {
                case 'admin':
                    if (!str_starts_with($current, 'admin')) {
                        return redirect()->route('admin.dashboard');
                    }
                    break;

                case 'vendedor':
                    if (!str_starts_with($current, 'vendedor')) {
                        return redirect()->route('vendedor.dashboard');
                    }
                    break;

                case 'cliente':
                    if (!str_starts_with($current, 'cliente')) {
                        return redirect()->route('cliente.dashboard');
                    }
                    break;

                default:
                    return redirect('/login');
            }
        }

        return $next($request);
    }
}
