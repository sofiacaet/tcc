<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // PROFESSOR - CURSO
            ["role_id" => 1, "resource_id" => 1, "permission" => 1],
            ["role_id" => 1, "resource_id" => 2, "permission" => 0],
            ["role_id" => 1, "resource_id" => 3, "permission" => 0],
            ["role_id" => 1, "resource_id" => 4, "permission" => 0],
            ["role_id" => 1, "resource_id" => 5, "permission" => 0],
            // PROFESSOR - ALUNO
            ["role_id" => 1, "resource_id" => 6, "permission" => 1],
            ["role_id" => 1, "resource_id" => 7, "permission" => 0],
            ["role_id" => 1, "resource_id" => 8, "permission" => 1],
            ["role_id" => 1, "resource_id" => 9, "permission" => 0],
            ["role_id" => 1, "resource_id" => 10, "permission" => 0],
             // PROFESSOR - ALUNO
            ["role_id" => 1, "resource_id" => 11, "permission" => 1],
            ["role_id" => 1, "resource_id" => 12, "permission" => 0],
            ["role_id" => 1, "resource_id" => 13, "permission" => 1],
            ["role_id" => 1, "resource_id" => 14, "permission" => 0],
            ["role_id" => 1, "resource_id" => 15, "permission" => 0],

            // PROFESSOR / GESTANTE (role_id = 1) - ORIENTAÇÕES
            ["role_id" => 1, "resource_id" => 16, "permission" => 1], // orientacao.index (Ver tela)
            ["role_id" => 1, "resource_id" => 17, "permission" => 1], // orientacao.create (Enviar mensagem)
            ["role_id" => 1, "resource_id" => 18, "permission" => 1], // orientacao.show (Ver detalhes)
            ["role_id" => 1, "resource_id" => 19, "permission" => 0], // orientacao.edit
            ["role_id" => 1, "resource_id" => 20, "permission" => 0], // orientacao.delete
            
            //  COORDENADOR - CURSO
            ["role_id" => 2, "resource_id" => 1, "permission" => 1],
            ["role_id" => 2, "resource_id" => 2, "permission" => 1],
            ["role_id" => 2, "resource_id" => 3, "permission" => 1],
            ["role_id" => 2, "resource_id" => 4, "permission" => 1],
            ["role_id" => 2, "resource_id" => 5, "permission" => 1],
            // COORDENADOR - ALUNO
            ["role_id" => 2, "resource_id" => 6, "permission" => 1],
            ["role_id" => 2, "resource_id" => 7, "permission" => 1],
            ["role_id" => 2, "resource_id" => 8, "permission" => 1],
            ["role_id" => 2, "resource_id" => 9, "permission" => 1],
            ["role_id" => 2, "resource_id" => 10, "permission" => 1],
             // COORDENADOR - ALUNO
            ["role_id" => 2, "resource_id" => 11, "permission" => 1],
            ["role_id" => 2, "resource_id" => 12, "permission" => 1],
            ["role_id" => 2, "resource_id" => 13, "permission" => 1],
            ["role_id" => 2, "resource_id" => 14, "permission" => 1],
            ["role_id" => 2, "resource_id" => 15, "permission" => 1],

            //  ORIENTAÇÕES
            ["role_id" => 2, "resource_id" => 16, "permission" => 1], // orientacao.index
            ["role_id" => 2, "resource_id" => 17, "permission" => 1], // orientacao.create
            ["role_id" => 2, "resource_id" => 18, "permission" => 1], // orientacao.show
            ["role_id" => 2, "resource_id" => 19, "permission" => 1], // orientacao.edit
            ["role_id" => 2, "resource_id" => 20, "permission" => 1], // orientacao.delete
        ];

        DB::table('permissions')->insert($data);
    }
}
