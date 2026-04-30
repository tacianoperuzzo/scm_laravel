<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserPostRequest;
use App\Http\Requests\Settings\UserStatusPostRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $usuarios = $this->userRepository->getAll()->load('pessoa');
        $id = $request->input('id');
        return Inertia::render('usuario/index',[
            'usuarios' => $usuarios,
            'usuario' => Inertia::optional(fn()=>$this->userRepository->getOne($id)->load('pessoa')),
        ]);
    }

    public function store(UserPostRequest $request)
    {
        $this->userRepository->create($request->validated());
        return response()->redirectToRoute('users.index');
    }

    public function update(UserPostRequest $request, $id)
    {
        $this->userRepository->update($id, $request->validated());
        return response()->redirectToRoute('users.index');
    }

    public function status(UserStatusPostRequest $request, $id)
    {
        $this->userRepository->updateStatus($id, $request->validated());
        return response()->redirectToRoute('users.index');
    }
}
