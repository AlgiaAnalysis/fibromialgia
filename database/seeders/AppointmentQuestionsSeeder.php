<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questions')->insert([
            [
                'que_name' => 'Há quanto tempo você sente dores pelo corpo?',
                'que_domain' => 'appointment_questions',
                'que_index' => 1,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Em quais regiões a dor é mais intensa?',
                'que_domain' => 'appointment_questions',
                'que_index' => 2,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Como você classificaria a intensidade da dor (leve, moderada, severa)?',
                'que_domain' => 'appointment_questions',
                'que_index' => 3,
                'created_at' => now(),
            ],
            [
                'que_name' => 'A dor piora em algum momento específico do dia ou com alguma atividade?',
                'que_domain' => 'appointment_questions',
                'que_index' => 4,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Você percebe alguma rigidez muscular, especialmente ao acordar?',
                'que_domain' => 'appointment_questions',
                'que_index' => 5,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Tem apresentado fadiga constante ou cansaço excessivo?',
                'que_domain' => 'appointment_questions',
                'que_index' => 6,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Como está seu padrão de sono? Tem dificuldade para dormir ou sono não reparador?',
                'que_domain' => 'appointment_questions',
                'que_index' => 7,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Sente que a dor está associada a algum estresse emocional recente?',
                'que_domain' => 'appointment_questions',
                'que_index' => 8,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Tem dificuldades de concentração ou lapsos de memória frequentes?',
                'que_domain' => 'appointment_questions',
                'que_index' => 9,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Já iniciou algum tratamento com analgésicos, antidepressivos ou anti-inflamatórios?',
                'que_domain' => 'appointment_questions',
                'que_index' => 10,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Quais atividades do dia a dia a dor está dificultando?',
                'que_domain' => 'appointment_questions',
                'que_index' => 11,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Já realizou exames laboratoriais para descartar outras doenças reumáticas?',
                'que_domain' => 'appointment_questions',
                'que_index' => 12,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Algum familiar já foi diagnosticado com fibromialgia ou outra doença reumática?',
                'que_domain' => 'appointment_questions',
                'que_index' => 13,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Você tem notado alterações no humor, como ansiedade ou depressão?',
                'que_domain' => 'appointment_questions',
                'que_index' => 14,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Usa alguma medicação contínua? Se sim, qual?',
                'que_domain' => 'appointment_questions',
                'que_index' => 15,
                'created_at' => now(),
            ],
        ]);        
    }
}
