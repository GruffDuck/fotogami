<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\VerificationCode;
use Carbon\Carbon;

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

        // 15 haneli rastgele kurtarma anahtarı oluştur
        $recoveryKey = Str::random(15);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'organization_type' => $request->organization_type,
            'organization_name' => $request->organization_name,
            'recovery_key' => $recoveryKey,
        ]);

        // Token oluştur
        $token = $user->createToken('MyApp')->plainTextToken;

        // Token ve kurtarma anahtarı ile birlikte kullanıcı bilgilerini döndür
        return response()->json([
            'user' => $user,
            'token' => $token,
            'recovery_key' => $recoveryKey
        ], 201);
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

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }


    // Kullanıcı çıkışı
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bu e-posta adresi sistemde kayıtlı değil.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'E-posta adresi doğrulandı.',
            'user' => $user
        ], 200);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'recovery_key' => 'required|string|size:15',
            'password' => 'required|min:8|confirmed',
        ]);

        // Kullanıcıyı ve kurtarma anahtarını kontrol et
        $user = User::where('email', $request->email)
            ->where('recovery_key', $request->recovery_key)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Geçersiz e-posta veya kurtarma anahtarı!'], 400);
        }

        // Yeni kurtarma anahtarı oluştur
        $newRecoveryKey = Str::random(15);

        // Şifreyi ve kurtarma anahtarını güncelle
        $user->password = Hash::make($request->password);
        $user->recovery_key = $newRecoveryKey;
        $user->save();

        return response()->json([
            'message' => 'Şifre başarıyla sıfırlandı!',
            'new_recovery_key' => $newRecoveryKey
        ]);
    }
    // Mevcut kullanıcının bilgilerini getiren endpoint
    public function currentUser(Request $request)
    {
        // Authenticated user (giriş yapmış kullanıcı)
        $user = $request->user();

        // Kullanıcı bilgilerini JSON formatında döndür
        return response()->json([$user], 200);
    }
}
