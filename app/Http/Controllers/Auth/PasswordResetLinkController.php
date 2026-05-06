<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Show the password reset link request page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/ForgotPassword', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRepository $userRepository, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'cpf' => 'required|string',
        ]);

        $user = $userRepository->findByCpfEmail($validated['cpf'], $validated['email'])?->load('pessoa');

        if (!$user) {
            return back()->withErrors(['fields' => __('Nenhuma conta encontrada com o CPF e email fornecidos.')]);
        }

        $user->email = $user->pessoa->email;
        $user->remember_token = app('auth.password.broker')->createToken($user);
        Mail::to($user->pessoa->email)->send(new ForgotPasswordMail($user));

        return back()->with('status', __('Um link de redefinição de senha será enviado se a conta existir.'));
    }
}
