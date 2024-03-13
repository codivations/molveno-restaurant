<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowAccessForRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(
        Request $request,
        Closure $next,
        string $allowedRoles = ""
    ): Response {
        $allowedRolesArray = explode("|", $allowedRoles);
        $hasRole = $request->user()->hasRole($allowedRolesArray);

        if (!$hasRole) {
            return redirect("/")->with(
                "status",
                "You are not authorized to view this page"
            );
        }

        return $next($request);
    }
}
