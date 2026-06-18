<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return $this->unauthorized('Unauthenticated');
        }

        $roleList = explode('|', $roles);

        if ($user->hasAnyRole($roleList)) {
            return $next($request);
        }

        return $this->forbidden('You do not have the required role to access this resource.');
    }
}
