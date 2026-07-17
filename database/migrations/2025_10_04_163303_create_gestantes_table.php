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
        Schema::create('gestantes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();//
            $table->string('telefone');//
            $table->decimal('altura', 4, 2);//4 digitos (total), 2 deles dps da virgula
            $table->date('data_nascimento');
            $table->string('cpf', 14)->unique();
            $table->string('estado_civil');
            $table->decimal('peso_atual', 5, 2);//

            // linhas adicionadas
            $table->string('foto')->nullable();
            // $table->unsignedBigInteger('consulta_id');
            // $table->foreign('consulta_id')->references('id')->on('consultas');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestantes');
    }
};
