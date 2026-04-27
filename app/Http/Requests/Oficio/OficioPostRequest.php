<?php

namespace App\Http\Requests\Oficio;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OficioPostRequest extends FormRequest
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
            'id' => 'nullable',
            'data'   => ['required', 'date'],
            'assunto'   => ['required', 'string'],
            'conteudo'   => ['required', 'string'],
            'tratamento' => 'nullable',
            'destinatario' => 'nullable',
            'cargo' => 'nullable',
            'municipio' => 'nullable',
        ];
    }
}
