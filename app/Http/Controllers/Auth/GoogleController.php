<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Allowed email domains
            $allowedDomains = [
                'gmail.com',
                'outlook.com',
                'hotmail.com',
                'yahoo.com',
                'icloud.com',
                'proton.me',
                'protonmail.com',
                'yandex.com',
            ];
            
            // Check email domain
            $email = $googleUser->getEmail();
            $emailDomain = substr(strrchr($email, "@"), 1);
            
            if (!in_array(strtolower($emailDomain), $allowedDomains)) {
                return redirect()->route('login')->with('error', 'Maaf, hanya email dengan domain ' . implode(', ', $allowedDomains) . ' yang diizinkan untuk mendaftar.');
            }
            
            // Check if user already exists by google_id
            $user = User::where('google_id', $googleUser->getId())->first();
            
            if (!$user) {
                // Check if email already exists (registered via email)
                $user = User::where('email', $googleUser->getEmail())->first();
                
                if ($user) {
                    // Link Google account to existing user
                    $user->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'password' => null,
                        'email_verified_at' => now(),
                    ]);
                }
            }
            
            // Check if user is blocked
            if ($user->isBlocked()) {
                return redirect()->route('login')->with('error', 'Akun Anda telah diblokir. Silakan hubungi admin untuk informasi lebih lanjut.');
            }
            
            // Login the user
            Auth::login($user, true);
            
            // Check if user is suspended - redirect with warning
            if ($user->isSuspended()) {
                return redirect('/')->with('warning', 'Peringatan: Akun Anda sedang dalam status suspend karena terdeteksi adanya aktivitas yang melanggar ketentuan layanan. Harap perbaiki perilaku Anda atau akun akan diblokir permanen.');
            }
            
            return redirect('/');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }
}
