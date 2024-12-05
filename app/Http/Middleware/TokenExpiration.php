<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $token = $user->currentAccessToken();
            $createdAt = $token->created_at;

            // Define expiration time (e.g., 30 days)
            $expirationTime = now()->subDays(30);

            if ($createdAt->lessThan($expirationTime)) {
                // Token has expired, revoke it
                $token->delete();

                return response()->json([
                    'message' => 'Token has expired',
                    'success' => false,
                ], 401);
            }
        }

        return $next($request);
    }
}
