<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pessoa\PessoaPostRequest;
use App\Http\Requests\User\UserPostRequest;
use App\Http\Requests\User\UserStatusPostRequest;
use App\Mail\ForgotPasswordMail;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Repositories\CargoRepository;
use App\Repositories\FuncaoRepository;
use App\Repositories\NivelPermissaoRepository;
use App\Repositories\PessoaRepository;
use App\Repositories\SetorRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    protected UserRepository $userRepository;
    protected PessoaRepository $pessoaRepository;

    public function __construct(UserRepository $userRepository, PessoaRepository $pessoaRepository)
    {
        $this->userRepository = $userRepository;
        $this->pessoaRepository = $pessoaRepository;
    }

    public function index(
        CargoRepository $cargoRepository,
        SetorRepository $setorRepository,
        FuncaoRepository $funcaoRepository,
        NivelPermissaoRepository $nivelPermissao,
        Request $request)
    {
        $usuarios = $this->userRepository->getAll()->load('pessoa');
        $cargos = $cargoRepository->getAll();
        $setores = $setorRepository->getAll();
        $funcoes = $funcaoRepository->getAll();
        $niveis = $nivelPermissao->getAll();
        $id = $request->input('id');
        return Inertia::render('usuario/index',[
            'usuarios' => $usuarios,
            'usuario' => Inertia::optional(fn()=>$this->userRepository->getOne($id)->load(['pessoa','nivelPermissao'])),
            'cargos' => $cargos,
            'setores' => $setores,
            'funcoes' => $funcoes,
            'niveis' => $niveis,
        ]);
    }

    public function store(UserPostRequest $request)
    {
        $user = $this->userRepository->create($request->validated());
        if ($user) {
            $this->pessoaRepository->create($request->validated()['pessoa']);
            $this->enviaEmailBoasVindas($user->id);
        }
        return response()->redirectToRoute('users.index');
    }

    public function update(UserPostRequest $request, $id)
    {
        $user =$this->userRepository->update($id, $request->validated());
        if (!$user) {
            return response()->redirectToRoute('users.index')->withErrors(['error' => 'Usuário não encontrado.']);
        }
        $this->pessoaRepository->update($user->pessoa->id, $request->validated()['pessoa']);

        return response()->redirectToRoute('users.index');
    }

    public function status(UserStatusPostRequest $request, $id)
    {
        $this->userRepository->updateStatus($id, $request->validated());
        return response()->redirectToRoute('users.index');
    }

    public function enviaEmailBoasVindas($id)
    {
        $user = $this->userRepository->getOne($id)->load('pessoa');
        if ($user) {
            $token = Password::broker()->createToken($user);
            $user->remember_token = $token;
            $user->save();
            Mail::to($user->email)->send(new WelcomeMail($user));
            return response()->json(['success' => 'E-mail de boas-vindas enviado com sucesso.']);
        }
        return response()->json(['error' => 'Usuário não encontrado.'], 404);
    }

    public function enviaEmailRecuperacaoSenha($id)
    {
        $user = $this->userRepository->getOne($id);
        if ($user) {
            $token = Password::broker()->createToken($user);
            $user->remember_token = $token;
            $user->save();
            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            return response()->json(['success' => 'E-mail de recuperação de senha enviado com sucesso.']);
        }
        return response()->json(['error' => 'Usuário não encontrado.'], 404);
    }

}
