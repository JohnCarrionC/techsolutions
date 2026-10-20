<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
            
            $email = $githubUser->email ?? ($githubUser->nickname . '@github.com');

            $user = User::where('github_id', $githubUser->id)
                      ->orWhere('email', $email)
                      ->first();

            if ($user) {
                if (!$user->github_id) {
                    $user->update(['github_id' => $githubUser->id]);
                }
            } else {
                $user = User::create([
                    'nombre' => $githubUser->name ?? $githubUser->nickname, // <-- Cambiado a 'nombre'
                    'email' => $email,
                    'github_id' => $githubUser->id,
                    'password' => Hash::make(Str::random(16)),
                ]);
            }

            Auth::login($user);

            return redirect()->intended('/');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Ocurrió un error al iniciar sesión con GitHub. Detalles: ' . $e->getMessage()]);
        }
    }
}