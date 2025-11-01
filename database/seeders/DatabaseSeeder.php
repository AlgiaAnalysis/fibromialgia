<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\QuestionsSeeder;
use Database\Seeders\FiqrReportSeeder;
use Database\Seeders\AppointmentQuestionsSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AppointmentQuestionsSeeder::class,
        ]);
    }
}
