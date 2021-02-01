<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth_token = $request->header('authorization');
        if(empty($auth_token)) {
            return response()->json([
                'success' => false,
                'error' => 'Api token mancante'
            ]);
        }
        $api_token = substr($auth_token, 7);
        $user = User::where('api_token', $api_token)->first();
        if(!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Api token errato'
            ]);
        }
        return $next($request);
    }
}
