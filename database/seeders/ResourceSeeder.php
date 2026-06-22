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

             ["name" => "exame.index"],      // 6
            ["name" => "exame.create"],     // 7
            ["name" => "exame.show"],       // 8
            ["name" => "exame.edit"],       // 9
            ["name" => "exame.delete"],     // 10
        ];
        DB::table('resources')->insert($data);
    }
}
