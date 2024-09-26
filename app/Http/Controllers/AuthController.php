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
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $token = Str::upper(Str::random(6)); // 6 karakterlik rastgele kod oluştur
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['email' => $user->email, 'token' => $token]
        );
        // Doğrulama kodunu kaydet ve geçerlilik süresini 10 dakika ayarla
        VerificationCode::create([
            'email' => $request->email,
            'code' => $token,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);
        Mail::to($user->email)->send(new VerificationCodeMail($token));

        return response()->json(['message' => 'Reset password link sent to your email', 'token' => $token]);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Doğrulama kodunu bul
        $verificationCode = VerificationCode::where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$verificationCode) {
            return response()->json(['message' => 'Geçersiz veya süresi dolmuş doğrulama kodu!'], 400);
        }

        // Kullanıcının şifresini güncelle
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Kullanıcı bulunamadı!'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Doğrulama kodunu sil
        $verificationCode->delete();

        return response()->json(['message' => 'Şifre başarıyla sıfırlandı!']);
    }
}
