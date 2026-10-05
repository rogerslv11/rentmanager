<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    public function __construct(protected ActivityLogger $logger) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (config('activitylogging.log_requests', false) && $request->user()) {
            $this->logger->logFromRequest($request);
        }

        return $response;
    }
}
