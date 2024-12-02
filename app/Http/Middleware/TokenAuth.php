<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get token from Authorization header
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Find the user by the token
        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Set the user on the request for further use
        auth()->login($user);

        return $next($request);
    }
}
