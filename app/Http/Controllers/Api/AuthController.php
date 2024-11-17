<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Kayıt Olma İşlemi
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Kullanıcı başarıyla kaydedildi',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // Giriş Yapma İşlemi
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Geçersiz kimlik bilgileri'], 401);
        }

        return response()->json([
            'message' => 'Giriş başarılı',
            'token' => $token
        ]);
    }

    // Çıkış Yapma İşlemi
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Cıkıs yapılırken bir hata olustu'], 500);
        }

        return response()->json(['message' => 'Başarıyla çıkış yapıldı']);
    }

    // Kullanıcı giriş yapmamışsa
    public function notAuth()
    {
        return response()->json(['message' => 'Kullanıcı giriş yapmamış'], 401);
    }
}
