<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

class AuthController extends Controller
{
    // Kullanıcı kaydı
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string',
            'organization_type' => 'nullable|string',
            'organization_name' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'organization_type' => $request->organization_type,
            'organization_name' => $request->organization_name,
        ]);

        // Token oluştur
        $token = $user->createToken('MyApp')->plainTextToken;

        // Token ile birlikte kullanıcı bilgilerini döndür
        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    // Kullanıcı girişi
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('MyApp')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }

    // Kullanıcı çıkışı
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // 6 haneli doğrulama kodu oluştur
        $code = rand(100000, 999999);

        // Doğrulama kodunu gönder
        Mail::to($request->email)->send(new VerificationCodeMail($code));

        return response()->json(['message' => 'Doğrulama kodu gönderildi!']);
    }
}
