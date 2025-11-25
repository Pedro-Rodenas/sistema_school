<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // app/Http/Controllers/Auth/SocialController.php

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            // Si hay un error al obtener el usuario de Google/GitHub
            return redirect('/login')->with('error', 'Hubo un problema al iniciar sesión');
        }

        // ... (Tu lógica para buscar, crear o actualizar el usuario) ...
        $user = User::where('provider_id', $socialUser->getId())
            ->where('provider', $provider)
            ->first();

        if (!$user && $socialUser->getEmail()) {
            $user = User::where('email', $socialUser->getEmail())->first();
        }

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        } else {
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        }

        // 1. Iniciar la sesión
        Auth::login($user);

        // 2. 🔑 REGENERAR LA SESIÓN (Solución al problema de redirección)
        request()->session()->regenerate();

        // 3. Redirigir directamente
        return redirect('/dashboard');
    }

    public function authenticate(Request $request)
    {
        // 1. Obtener y validar las credenciales
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            // Regenerar la sesión para prevenir ataques de fijación de sesión
            $request->session()->regenerate();

            // Redirigir al usuario a la URL que intentaron acceder o al /dashboard
            return redirect()->intended('/dashboard');
        }

        // 3. Si la autenticación falla, redirigir con error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }
}
