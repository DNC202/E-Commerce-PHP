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
use Illuminate\Support\Facades\Auth;

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
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 200);
        }

        // Check if the user exists and is not deleted
        $user = User::find($request->email);

        // if (!$user) {
        //     return response()->json(['message' => 'Tài khoản không tồn tại hoặc đã bị xóa.'], 401);
        // }

        // Attempt to authenticate the user
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $secretKey = env('JWT_SECRET');
            $expirationTime = time() + 3600; // Hạn sử dụng của token là 1 giờ (3600 giây)

            $tokenData = [
                'userId' => $user->id,
                'exp' => $expirationTime,
            ];
            $token = JWT::encode($tokenData, $secretKey, 'HS256');
            setcookie('access_token', $token, [
                'expires' => $expirationTime,
                'path' => '/',
                'domain' => '127.0.0.1',
                'samesite' => 'None',
                'secure' => true,
                'httponly' => true
            ]);

            return response()->json($user);
        }

        // Authentication failed
        return response()->json(['message' => 'Đăng nhập không thành công. Vui lòng kiểm tra lại email và mật khẩu.'], 401);
    }

    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 401,
    //             'message' => $validator->messages()
    //         ], 401);
    //     } else {
    //         $user = User::where('email', $request->email)->first();
    //         if (!$user || !Hash::check($request->password, $user->password)) {
    //             return response()->json([
    //                 'status' => 401,
    //                 'message' => 'Wrong email or password. Please try again.',
    //             ], 401);
    //         }
    //     }
    //     $secretKey = env('JWT_SECRET');
    //     $expirationTime = time() + 3600; // Hạn sử dụng của token là 1 giờ (3600 giây)

    //     $tokenData = [
    //         'userId' => $user->id,
    //         'exp' => $expirationTime,
    //     ];
    //     $token = JWT::encode($tokenData, $secretKey, 'HS256');
    //     setcookie('access_token', $token, [
    //         'expires' => $expirationTime,
    //         'path' => '/',
    //         'domain' => '127.0.0.1',
    //         'samesite' => 'None',
    //         'secure' => true,
    //         'httponly' => true
    //     ]);
    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Đăng nhập thành công',
    //         // 'token' => $token
    //     ], 200);

    // }

    public function checkUser(Request $request)
    {
        $token = Cookie::get('access_token');
        $secretKey = env('JWT_SECRET');
        try {
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
            $userId = $decoded->userId;
            $user = User::find($userId);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json("Lỗi xác minh token", 401);
        }
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
        Auth::logout();

        return response()->json(['message' => 'Đăng xuất thành công'], 200);
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