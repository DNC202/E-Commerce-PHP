<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Firebase\JWT\JWT as JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function getUserByToken($request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $decoded = JWT::decode($token, new Key(Config::get('JWT_SECRET')), ['HS256']);
            $id = $decoded->data->id;
            $user = User::find($id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
    }
}