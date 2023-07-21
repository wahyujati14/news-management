<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        echo json_encode(response()->json([
            'OUT_STAT' => false,
            'OUT_MESS' => 'Token Not Valid',
        ], 401)->getData()); die();
    }
}
