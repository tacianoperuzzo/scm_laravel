<?php

namespace App\Http\Requests\Pessoa;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class PessoaPostRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'pessoa.id' => 'nullable',
            'pessoa.cpf' => ['required','string','max:11'],
            'pessoa.nome' => ['required', 'string', 'max:255'],
            'pessoa.email' => ['required', 'string', 'email'],
            'pessoa.telefone' => ['nullable', 'string', 'max:255'],
            'pessoa.nascimento' => ['nullable', 'date'],
            'pessoa.endereco' => ['nullable', 'string', 'max:255'],
            'pessoa.endereco_numero' => ['nullable', 'string', 'max:255'],
            'pessoa.endereco_complemento' => ['nullable', 'string', 'max:255'],
            'pessoa.endereco_municipio' => ['nullable', 'string', 'max:255'],
            'pessoa.endereco_cep' => ['nullable', 'string', 'max:9'],
            'pessoa.foto_url' => ['nullable', 'string', 'max:255'],
            'pessoa.matricula' => ['nullable', 'string', 'max:255'],
            'pessoa.postograd_id' => ['required','integer'],
            'pessoa.setor_id' => ['required','integer'],
            'pessoa.funcao_id' => ['required','integer'],
            'pessoa.pasta' => ['nullable', 'string', 'max:255'],
            'pessoa.nome_guerra' => ['nullable', 'string', 'max:255'],
            'pessoa.data_entrada' => ['nullable', 'date'],
            'pessoa.data_saida' => ['nullable', 'date'],
            'pessoa.observacao' => ['nullable', 'string'],
        ];
    }
}
