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
        Schema::create('oficios', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->integer('ano');
            $table->date('data');
            $table->string('tratamento')->nullable();
            $table->string('destinatario')->nullable();
            $table->string('cargo')->nullable();
            $table->string('assunto');
            $table->string('municipio');
            $table->text('conteudo')->nullable();
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
        Schema::dropIfExists('oficios');
    }
};
