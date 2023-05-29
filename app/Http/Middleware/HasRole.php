<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Responses\SendResponse;
use Closure;
use Illuminate\Http\Request;

class HasRole
{
    /**
     * Handle the incoming request.
     * Verifica si el usuario que ha echo la petision tiene al menos uno de los roles
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $roles Roles a verificar, separados por |
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $roles = explode('|', $roles);
        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }
        return SendResponse::error('Forbidden', 403);
    }
}
