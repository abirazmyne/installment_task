<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenaltySettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Define default penalty percentages
        $penalties = [
            0.00,
            1.00,
            2.00,
            3.00,
            4.00,
            5.00,
            6.00,
            7.00,
            8.00,
            9.00
        ];

        foreach ($penalties as $percentage) {
            DB::table('penalty_settings')->insert([
                'penalty_percentage' => $percentage,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
