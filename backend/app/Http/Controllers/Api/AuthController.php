<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\EmailVerification;
use Firebase\JWT\JWT as JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', "register", 'active']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
            // 'phone' => 'string|digits:10',
            // 'address' => 'string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        } else {
            $expirationDate = time() * 3600;
            $data = ['name' => $request->name, 'email' => $request->email, 'password' => $request->password, 'exp' => $expirationDate];
            
            $secretKey = env('JWT_SECRET');
            $token = JWT::encode($data, $secretKey, 'HS256');

            Mail::to($request->email)->send(new EmailVerification($request->email, $token));
            return response()->json([
                'status' => 200,
                'message' => 'Vui lòng xác thực tài khoản để tiếp tục.',
                'token' => $token,
            ], 200);
        }
    }

    public function active($token)
    {
        $secretKey = env('JWT_SECRET');
        try {
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
            // Assuming $decoded contains user information
            $userData = [
                'name' => $decoded->name,
                'email' => $decoded->email,
                'password' => $decoded->password,
                'email_verified_at' => now(),
            ];
            // return response()->json($decoded);
            User::create($userData);
            return response()->json("Đăng ký thành công!", 201);
        } catch (\Exception $e) {
            return response()->json($e, 401);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 401,
                'message' => $validator->messages()
            ], 401);
        } else {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Wrong email or password. Please try again.',
                ], 401);
            }
        }
        $expirationDate = time() * 3600;
        $data = ['email' => $request->email, 'password' => $request->password, 'exp' => $expirationDate];
        
        $secretKey = env('JWT_SECRET');
        $token = JWT::encode($data, $secretKey, 'HS256');
        return response()->json([
            'status' => 200,
            'message' => 'Login successfully.',
            'token' => $token,
        ], 200);
    }

    

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60
    //     ]);
    // }
}