<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        $authenticate = true;

        if (!$token) {
            $authenticate = false;
        } 
        
        $user = User::where('token', $token)->first();
        if (!$user) {
            $authenticate = false;
        }else{
            Auth::login($user);
        }


        if($authenticate){
            return $next($request);
        }else{
            return response()->json([
                'errors' => [
                    'message' => [
                        'Unauthorized'
                    ]
                ]
            ], 401);
        }
 
    }
}
