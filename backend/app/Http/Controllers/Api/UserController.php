<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Auth\VerifyEmailController;

use App\Models\User;
use Firebase\JWT\JWT as JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{
    //

    public function getAllUser()
    {
        $users = User::all();
        return response()->json($users);
    }


    public function getUserById($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }


    public function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first();
        return response()->json($user);
    }

    public function getUserByToken(Request $request)
    {

        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $secretKey = env('JWT_SECRET');
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
            $email = $decoded->data->email;
            $user = User::find($email);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
    }
}