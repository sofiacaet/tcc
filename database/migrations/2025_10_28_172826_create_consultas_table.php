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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_consulta');
            $table->date('data');
            $table->time('horario');
           
            $table->unsignedBigInteger('gestante_id');
            $table->foreign('gestante_id')->references('id')->on('gestantes');

            // --- NOVOS CAMPOS ADICIONADOS ---
            $table->string('status')->default('Agendada'); // Agendada / Realizada
            $table->decimal('peso_atual', 5, 2)->nullable();
            $table->string('pressao_arterial')->nullable();
            $table->integer('batimentos_fetais')->nullable();
            $table->text('evolucao_clinica')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
