<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // CURSO
            ["name" => "consulta.index"],      // 1
            ["name" => "consulta.create"],     // 2
            ["name" => "consulta.show"],       // 3
            ["name" => "consulta.edit"],       // 4
            ["name" => "consulta.delete"],     // 5
            // ALUNO
            ["name" => "gestante.index"],      // 6
            ["name" => "gestante.create"],     // 7
            ["name" => "gestante.show"],       // 8
            ["name" => "gestante.edit"],       // 9
            ["name" => "gestante.delete"],     // 10

             ["name" => "exame.index"],      // 11
            ["name" => "exame.create"],     // 12
            ["name" => "exame.show"],       // 13
            ["name" => "exame.edit"],       // 14
            ["name" => "exame.delete"],     // 15

            // ORIENTAÇÕES 
            ["name" => "orientacao.index"],    // 16
            ["name" => "orientacao.create"],   // 17
            ["name" => "orientacao.show"],     // 18
            ["name" => "orientacao.edit"],     // 19
            ["name" => "orientacao.delete"],   // 20
        ];
        DB::table('resources')->insert($data);
    }
}
