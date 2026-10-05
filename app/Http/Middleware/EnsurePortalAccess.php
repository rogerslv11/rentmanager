<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePortalAccess
{
    public function handle(Request $request, Closure $next, string $type): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($type === 'tenant' && ! $user->hasRole('tenant')) {
            abort(403, 'Acesso restrito a inquilinos.');
        }

        if ($type === 'owner' && ! $user->hasRole('owner')) {
            abort(403, 'Acesso restrito a proprietários.');
        }

        return $next($request);
    }
}
