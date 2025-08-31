<?php

namespace App\Http\Controllers\OAuth;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

use function Symfony\Component\Clock\now;

class SocialAuthController extends Controller
{

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            // Authentification avec le fournisseur social
            $socialUser = Socialite::driver($provider)->user();

            // Vérifie si l'email est récupéré
            if (!$socialUser->getEmail()) {
                return redirect()->route('login')->with('error', 'Impossible de récupérer votre email.');
            }

            // Vérifie si l'utilisateur existe déjà
            $user = User::where('email', $socialUser->getEmail())->first();

            // Si l'utilisateur n'existe pas, on le crée
            if (!$user) {
                $user = User::create([
                    'name' => $socialUser->getName() ?? explode('@', $socialUser->getEmail())[0],
                    'email' => $socialUser->getEmail(),
                    'email_verified_at' => now(),
                    'provider_id' => $socialUser->getId(),
                    'provider' => $provider,
                    'password' => bcrypt(uniqid()),
                    'profile_picture' => $socialUser->getAvatar(),
                ]);
            }

            // Connexion de l'utilisateur
            Auth::login($user);

            return redirect('/home')->with('success', 'Connexion réussie !');
        } catch (\Exception $e) {
            // Gestion des erreurs
            Log::error("Erreur de connexion avec {$provider}: " . $e->getMessage());
            return redirect()->route('login')->with('error', 'Erreur de connexion avec ' . $provider . ' : ' . $e->getMessage());
        }
    }
}
