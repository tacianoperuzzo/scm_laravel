<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
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
        $request->validate([
            'cpf' => ['required', 'string'],
            'email' => 'required|email',
        ]);

        $user = $userRepository->findByCpfEmail($request->string('cpf'), $request->string('email'));

        if (!$user || !$user->ativo) {
            throw ValidationException::withMessages([
                'cpf' => trans('auth.failed'),
                'email' => trans('auth.failed'),
            ]);
        }

        Password::sendResetLink(
            $request->only('email')
        );

        return back()->with('status', __('A reset link will be sent if the account exists.'));
    }
}
