<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()->route('login');
        }

        abort_if(
            $user->rol === null,
            Response::HTTP_FORBIDDEN,
            'No tienes un rol asignado.',
        );

        abort_unless(
            in_array($user->rol->nombre, $roles, true),
            Response::HTTP_FORBIDDEN,
            'No tienes permiso para acceder a esta ruta.',
        );

        return $next($request);
    }
}
