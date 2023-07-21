<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\PersonalAccessToken;

class Token extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$guards)
    {

        $token = $request->bearerToken();

        if(!$token) {
            $this->unauth($request);
        }

        try {

            $token = Crypt::decryptString($token);

            [$id, $token] = explode('|', $token, 2);
    
            if (strpos($token, '|') === false) {
                $check_token = PersonalAccessToken::where('token', hash('sha256', $token))->first();
    
                if($check_token != null) {
                    $request->merge(["role" => $check_token->name, "user_id" => $check_token->tokenable_id]);
                    return $next($request);
                } else {
                    $this->unauth($request);
                }
    
            } else {
                $this->unauth($request);
            }

        } catch (DecryptException $e) {
            $this->unauth($request);
        }

    }

    private function unauth($request)
    {
        echo json_encode(response()->json([
            'OUT_STAT' => false,
            'OUT_MESS' => 'Token Not Valid',
        ], 401)->getData()); die();
    }
}
