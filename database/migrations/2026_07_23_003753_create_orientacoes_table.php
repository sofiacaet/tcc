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
        Schema::create('orientacoes', function (Blueprint $table) {
            $table->id();
            
            // Relacionamento com a Gestante (a qual prontuário/perfil pertence essa mensagem)
            $table->foreignId('gestante_id')->constrained('gestantes')->onDelete('cascade');
            
            // Relacionamento com o Usuário que enviou a mensagem (pode ser o Médico/Coordenador ou a própria Gestante)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // O texto da orientação/observação
            $table->text('mensagem');
            
            $table->timestamps(); // Cria as colunas created_at e updated_at (servirão como a data/hora do envio)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orientacoes');
    }
};
