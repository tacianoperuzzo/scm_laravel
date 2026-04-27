<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $usuarios = User::all()->load('pessoa');
        $id = $request->input('id');
        return Inertia::render('usuario/index',[
            'usuarios' => $usuarios,
            'usuario' => Inertia::optional(fn()=>User::find($id)->load('pessoa')),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cpf' => ['required','string','max:11','unique:users,cpf'],
            'pessoa.nome' => ['required', 'string', 'max:255'],
            'pessoa.email' => ['required', 'string', 'email', 'unique:pessoas,email'],
            'password' => ['required','string','max:100','confirmed'],
        ]);
        $user = User::create([...$validated, 'active'=>1]);
        $pessoa = Pessoa::create([...$validated['pessoa'], 'cpf' => $validated['cpf']]);
        return response()->redirectToRoute('user.users');
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $usuario = User::find($id);
        $pessoa = $usuario->pessoa;
        if (!$usuario) throw new NotFoundHttpException;
        $validated = $request->validate([
            'cpf' => ['required','string','max:11',"unique:users,cpf,$id,id"],
            'pessoa.nome' => ['required', 'string', 'max:255'],
            'pessoa.email' => ['required', 'string', 'email', "unique:pessoas,email,$pessoa->id,id"],
            'active' => ['required', 'integer', 'between:0,1']
        ]);
        $password = $request->validate([
            'password' => ['nullable', 'string', 'max:255', 'confirmed'],
        ]);
        $usuario->update($validated);
        $pessoa->update([...$validated['pessoa'], 'cpf' => $validated['cpf']]);
        if ($password['password']??null) {
            $usuario->update($password);
        }
        return response()->redirectToRoute('user.users');
    }

    public function status(Request $request, $id)
    {
        $usuario = User::find($id);
        if (!$usuario) throw new NotFoundHttpException;
        $validated = $request->validate([
            'active' => ['required', 'integer', 'between:0,1']
        ]);
        $usuario->update($validated);
        return response()->redirectToRoute('user.users');
    }
}
