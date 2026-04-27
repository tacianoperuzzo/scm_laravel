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
        Schema::create('efetivo', function (Blueprint $table) {
            $table->id();
            $table->integer('pessoa_id');
            $table->string('matricula');
            $table->integer('postograd_id');
            $table->integer('setor_id');
            $table->integer('funcao_id');
            $table->string('pasta');
            $table->date('data_entrada');
            $table->date('data_saida');
            $table->text('observacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('efetivo');
    }
};
