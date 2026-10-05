<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ActivityLogger
{
    public function log(
        string $action,
        ?Model $subject = null,
        ?string $description = null,
        array $properties = [],
        ?int $userId = null,
        ?int $organizationId = null,
    ): ActivityLog {
        $user = auth()->user();

        return ActivityLog::create([
            'organization_id' => $organizationId ?? ($user?->organization_id),
            'user_id' => $userId ?? $user?->id,
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->getKey(),
            'description' => $description,
            'properties' => $properties,
            'ip_address' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
        ]);
    }

    public function logFromRequest(Request $request): ActivityLog
    {
        return $this->log(
            action: strtolower($request->method()).'.'.str_replace('/', '.', trim($request->path(), '/')),
            description: null,
            properties: [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'status' => null,
            ],
        );
    }
}
