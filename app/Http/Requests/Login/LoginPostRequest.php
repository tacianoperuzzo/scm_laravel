<?php

namespace App\Http\Requests\Login;

use App\Repositories\UserRepository;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class LoginPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(UserRepository $userRepository, $idUser): array
    {
        $user = $idUser ? $userRepository->getOne($idUser) : null;
        return [
            'id' => 'nullable',
            'email' => ['required','string','email','max:255',Rule::unique("users","email")->ignore($user?->email,'email')],
            'cpf' => ['required','string','max:11',Rule::unique("users","cpf")->ignore($user?->cpf,'cpf')],
            'ativo' => ['required','integer','between:0,1'],
            'nivel_permissao_id' => ['required','integer'],
        ];
    }
}
