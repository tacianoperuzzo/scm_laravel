<?php

namespace App\Http\Requests\RelatorioServico;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RelatorioServicoPostRequest extends FormRequest
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
            'numero' => ['nullable','integer'],
            'mes_dia' => ['required', 'string', 'max:5'],
            'ano' => ['required', 'integer'],
            'data_pre' => ['required', 'date'],
            'data_pos' => ['required', 'date'],
            'visto' => ['required', 'string'],
            'escalas' => ['required', 'string'],
            'alteracoes' => ['required', 'string'],
            'equipamentos' => ['required', 'string'],
            'instalacoes' => ['required', 'string'],
            'remetente' => ['required', 'string', 'max:255'],
            'substituto' => ['required', 'string', 'max:255'],
            'local_data' => ['required', 'string', 'max:255'],
            'assinatura' => ['required', 'string'],
            'created_by' => ['required', 'string', 'max:11'],
            'updated_by' => ['required', 'string', 'max:11'],
        ];
    }

    public function prepareForValidation()
    {
        $dataPos = $this->input('data_pos');
        if ($dataPos) {
            try {
                $formattedDate = Carbon::parse($dataPos)->format('Y-m-d');
                $this->merge(['data_pos' => $formattedDate]);
            } catch (\Exception $e) {
                Log::error('Erro ao formatar a data: ' . $e->getMessage());
            }
        }
        $dataPre = $this->input('data_pre');
        if ($dataPre) {
            try {
                $this->merge(['mes_dia' => Carbon::parse($dataPre)->format('m-d')]);
                $this->merge(['ano' => Carbon::parse($dataPre)->format('Y')]);
            } catch (\Exception $e) {
                Log::error('Erro ao formatar a data: ' . $e->getMessage());
            }
        }
        $this->merge([
            'created_by' => Auth::user()->cpf ?? null,
            'updated_by' => Auth::user()->cpf ?? null,
        ]);
    }
}
