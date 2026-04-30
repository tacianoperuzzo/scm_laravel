<?php

namespace App\Http\Requests\Settings;

use App\Repositories\UserRepository;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(UserRepository $userRepository): array
    {
        $user = $this->route('user') ? $userRepository->getOne($this->route('user')) : null;
        $pessoa = $user ? $user->pessoa : null;
        $pessoa_id = $pessoa ? $pessoa->id : null;
        return [
            'cpf' => ['required','string','max:11',"unique:users,cpf,{$this->route('user')}"],
            'pessoa.nome' => ['required', 'string', 'max:255'],
            'pessoa.email' => ['required', 'string', 'email', "unique:pessoas,email,{$pessoa_id}"],
            'active' => [Rule::requiredIf(fn() => $this->route('user')), 'integer', 'between:0,1']
        ];
    }
}
