<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCmsPortalAccess
{
    private const CUSTOMER_ROLE = 'customer';

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->hasRole(self::CUSTOMER_ROLE)) {
            return response()->json([
                'message' => 'Customer accounts cannot access the admin portal.',
            ], 403);
        }

        return $next($request);
    }
}
