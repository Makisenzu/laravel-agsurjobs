<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permissions): Response
    {
        $user = $request->user();

        if (! $user) {
            return $this->unauthorized('Unauthenticated');
        }

        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        $permissionList = explode('|', $permissions);

        foreach ($permissionList as $permission) {
            if ($user->hasPermission($permission)) {
                return $next($request);
            }
        }

        return $this->forbidden('You do not have the required permission to access this resource.');
    }
}
