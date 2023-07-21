<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AuthResource;
use Validator;

class AuthController extends Controller
{

    /**
     * User Login by Email and Password to Generate Token.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => false,
                    'message' => $validator->messages()->all()
                ], 422);
                
            }

            $credentials = $request->only('email', 'password');

            if(Auth::attempt($credentials)) {
                
                $user = Auth::user();
                $user['token'] = $user->createToken($user->level)->plainTextToken;
                
                $data = AuthResource::make($user);
        
                return response()->json([
                    'status' => true,
                    'message' => 'User Berhasil Login',
                    'data' => $data
                ], 200);

            }
            
            return response()->json([
                'status' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }

    }
}
