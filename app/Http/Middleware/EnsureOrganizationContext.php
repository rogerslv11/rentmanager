<?php

namespace App\Http\Middleware;

use App\Support\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganizationContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if ($user->is_super_admin && ! $user->organization_id) {
            return $next($request);
        }

        if (! $user->organization_id) {
            abort(403, 'Usuário sem organização vinculada.');
        }

        TenantContext::set($user->organization);

        return $next($request);
    }
}
