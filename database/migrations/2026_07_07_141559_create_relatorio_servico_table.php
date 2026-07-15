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
        Schema::create('relatorio_servico', function (Blueprint $table) {
            $table->id();
            $table->integer('numero')->unsigned();
            $table->string('mes_dia', 5);
            $table->integer('ano');
            $table->date('data_pos');
            $table->text('visto');
            $table->text('escalas');
            $table->text('alteracoes');
            $table->text('equipamentos');
            $table->text('instalacoes');
            $table->string('remetente', 255);
            $table->string('substituto', 255);
            $table->string('data', 255);
            $table->text('assinatura');
            $table->timestamps();
            $table->string('created_by', 11);
            $table->string('updated_by', 11);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relatorio_servico');
    }
};
