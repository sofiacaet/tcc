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
            $table->string('nome');
            $table->unsignedTinyInteger('ref_dia');
            $table->unsignedInteger('kcal_dia');
            $table->text('observacoes')->nullable();
           
            $table->unsignedBigInteger('gestante_id');
            $table->foreign('gestante_id')->references('id')->on('gestantes');

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
