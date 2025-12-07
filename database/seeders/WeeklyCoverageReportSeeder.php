<?php

namespace Database\Seeders;

use App\Models\Establishment;
use App\Models\Program;
use App\Models\WeeklyCoverageReport;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WeeklyCoverageReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $establishment = Establishment::first();
        if (!$establishment) {
            return;
        }

        $user = User::where('establishment_id', $establishment->id)->first();
        if (!$user) {
            return;
        }

        // Get some programs
        $programs = Program::where('establishment_id', $establishment->id)->get();

        foreach ($programs as $program) {
            // Create 8-12 weekly reports per program (roughly 2-3 months of data)
            for ($i = 0; $i < rand(8, 12); $i++) {
                $totalPlanned = $program->nbr_hours ?? 50;
                $hoursProgress = ($i / 12) * $totalPlanned; // Gradually progress coverage

                WeeklyCoverageReport::firstOrCreate(
                    [
                        'program_id' => $program->id,
                        'recorded_by_user_id' => $user->id,
                        'establishment_id' => $establishment->id,
                    ],
                    [
                        'nbr_hours_done' => max(0, (int)$hoursProgress),
                        'nbr_lesson_done' => max(0, rand((int)($hoursProgress / 5), (int)($hoursProgress / 3))),
                        'nbr_lesson_dig_done' => max(0, rand(0, (int)($hoursProgress / 10))),
                        'nbr_tp_done' => max(0, rand(0, (int)($hoursProgress / 15))),
                        'nbr_tp_dig_done' => max(0, rand(0, (int)($hoursProgress / 20))),
                        'created_at' => now()->subWeeks($i),
                        'updated_at' => now()->subWeeks($i),
                    ]
                );
            }
        }

        $this->command->info('Weekly coverage reports seeded successfully!');
    }
}
