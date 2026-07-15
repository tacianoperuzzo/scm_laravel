<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('cpf', 11)->unique();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('telefone')->nullable();
            $table->date('nascimento')->nullable();
            $table->string('endereco')->nullable();
            $table->string('endereco_numero')->nullable();
            $table->string('endereco_complemento')->nullable();
            $table->string('endereco_municipio')->nullable();
            $table->string('endereco_cep')->nullable();
            $table->string('foto')->nullable();
            $table->string('matricula')->nullable();
            $table->integer('postograd_id')->nullable();
            $table->enum('corporacao', ['PM', 'BM'])->nullable();
            $table->string('nome_guerra')->nullable();
            $table->integer('setor_id')->nullable();
            $table->integer('funcao_id')->nullable();
            $table->string('pasta')->nullable();
            $table->date('data_entrada')->nullable();
            $table->date('data_saida')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas');
    }
};
