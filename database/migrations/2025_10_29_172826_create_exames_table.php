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
        Schema::create('exames', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_exame');
            $table->unsignedBigInteger('gestante_id');
            $table->foreign('gestante_id')->references('id')->on('gestantes');
            $table->string('status')->default('Solicitado'); // 'Solicitado' ou 'Recebido'
            $table->string('documento')->nullable();
            $table->string('documento_guia')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exames');
    }
};
