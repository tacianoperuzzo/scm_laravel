<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Show the password reset page.
     */
    public function create(UserRepository $userRepository, Request $request): Response
    {
        $token = $request->route('token');
        $email = $request->email;
        $user = $userRepository->findByEmail($email)?->load('pessoa');
        $user->email = $user->pessoa->email;
        $status = Password::broker()->tokenExists($user, $token);

        if (!$status) {
            return Inertia::render('auth/recovery_fail');
        }

        return Inertia::render('auth/reset_password', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRepository $userRepository,Request $request)
    {
        $validated = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'cpf' => 'required|string|size:11',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = $userRepository->findByCpfEmail($validated['cpf'], $validated['email'])?->load('pessoa');
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => [__('Erro, usuário não encontrado com estas credenciais.')],
            ]);
        }

        $user->email = $user->pessoa->email;
        $status = Password::broker()->tokenExists($user, $validated['token']);
        if (!$status) {
            throw ValidationException::withMessages([
                'token' => [__('Token inválido ou expirado.')],
            ]);
        }

        Password::broker()->deleteToken($user);

        unset($user->email);
        $user->password = Hash::make($validated['password']);
        $user->setRememberToken(Str::random(60));
        $user->save();


        event(new PasswordReset($user));

        return Inertia::render('auth/recovery_success');

    }
}
