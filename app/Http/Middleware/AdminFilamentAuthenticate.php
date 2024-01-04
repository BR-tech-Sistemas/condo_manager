<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticateMiddleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminFilamentAuthenticate extends FilamentAuthenticateMiddleware
{
    protected function redirectTo($request): ?string
    {
        return route('filament.app.auth.login');
    }

}
