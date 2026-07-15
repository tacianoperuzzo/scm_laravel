<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Login\LoginPostRequest;
use App\Http\Requests\Pessoa\PessoaPostRequest;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

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
        $idUser = $this->route('user');
        $regrasLogin = (new LoginPostRequest())->rules($userRepository, $idUser);
        $regrasPessoa = (new PessoaPostRequest())->rules();
        return array_merge($regrasLogin, $regrasPessoa);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => $this->input('pessoa.email') ? strtolower($this->input('pessoa.email')) : null,
            'pessoa' => [
                ...$this->input('pessoa'),
                'cpf' => $this->input('cpf') ? preg_replace('/[^0-9]/', '', $this->input('cpf')) : null,
                'nascimento' => $this->input('pessoa.nascimento') ? Carbon::createFromFormat('d/m/Y', $this->input('pessoa.nascimento'))->format('Y-m-d') : null,
                'data_entrada' => $this->input('pessoa.data_entrada') ? Carbon::createFromFormat('d/m/Y', $this->input('pessoa.data_entrada'))->format('Y-m-d') : null,
                'data_saida' => $this->input('pessoa.data_saida') ? Carbon::createFromFormat('d/m/Y', $this->input('pessoa.data_saida'))->format('Y-m-d') : null,
            ]
        ]);
    }
}
