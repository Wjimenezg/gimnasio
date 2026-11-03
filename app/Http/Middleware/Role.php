<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class Role {
    public function handle(Request $request, Closure $next, string ...$roles) {
        abort_unless(in_array($request->user()?->role, $roles), 403, 'No tienes permiso para esta sección.');
        return $next($request);
    }
}
