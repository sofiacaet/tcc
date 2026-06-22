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
            ["name" => "dieta.index"],      // 1
            ["name" => "dieta.create"],     // 2
            ["name" => "dieta.show"],       // 3
            ["name" => "dieta.edit"],       // 4
            ["name" => "dieta.delete"],     // 5
            // ALUNO
            ["name" => "gestante.index"],      // 6
            ["name" => "gestante.create"],     // 7
            ["name" => "gestante.show"],       // 8
            ["name" => "gestante.edit"],       // 9
            ["name" => "gestante.delete"],     // 10

             ["name" => "plano.index"],      // 6
            ["name" => "plano.create"],     // 7
            ["name" => "plano.show"],       // 8
            ["name" => "plano.edit"],       // 9
            ["name" => "plano.delete"],     // 10
        ];
        DB::table('resources')->insert($data);
    }
}
