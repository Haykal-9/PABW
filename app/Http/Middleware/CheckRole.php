<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Map role names to IDs based on UserRoleSeeder
        // admin = 1, kasir = 2, member = 3
        $roleIds = [
            'admin' => 1,
            'kasir' => 2,
            'customer' => 3, // using 'customer' keyword for routes, maps to 'member' role (id 3)
            'member' => 3
        ];

        // If generic 'auth' check is passed without role param (shouldn't happen with strict typing but good safety)
        if (!$role) {
            return $next($request);
        }

        // Check if user has the required role ID
        if (isset($roleIds[$role]) && $user->role_id === $roleIds[$role]) {
            return $next($request);
        }

        // Redirect unauthorized access to their own dashboard
        return match ($user->role_id) {
            1 => redirect()->route('admin.dashboard'),
            2 => redirect()->route('kasir.index'),
            3 => redirect('/'), // Customer home
            default => redirect('/login'),
        };
    }
}
