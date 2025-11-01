<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questions')->insert([
            //? First Domain
            [
                'que_name' => 'Escovar ou pentear os cabelos',
                'que_domain' => 'first_domain',
                'que_index' => 1,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Caminhar por 20 minutos sem parar',
                'que_domain' => 'first_domain',
                'que_index' => 2,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Preparar uma refeição caseira',
                'que_domain' => 'first_domain',
                'que_index' => 3,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Passar o aspirador de pó ou esfregar ou varrer o chão',
                'que_domain' => 'first_domain',
                'que_index' => 4,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Levantar e carregar uma sacola de mercado cheia',
                'que_domain' => 'first_domain',
                'que_index' => 5,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Subir um lance de escadas',
                'que_domain' => 'first_domain',
                'que_index' => 6,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Trocar a roupa de cama',
                'que_domain' => 'first_domain',
                'que_index' => 7,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Ficar sentado(a) continuamente por 45 minutos',
                'que_domain' => 'first_domain',
                'que_index' => 8,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Sair para compras de comida ou de roupas',
                'que_domain' => 'first_domain',
                'que_index' => 9,
                'created_at' => now(),
            ],
            //? Second Domain
            [
                'que_name' => 'Fui impedido(a) de finalizar a maioria de minhas tarefas/objetivos da semana',
                'que_domain' => 'second_domain',
                'que_index' => 1,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Senti-me totalmente dominado(a) pelos sintomas de fibromialgia',
                'que_domain' => 'second_domain',
                'que_index' => 2,
                'created_at' => now(),
            ],
            //? Third Domain
            [
                'que_name' => 'Por favor, avalie de zero a dez o seu nível de dor',
                'que_domain' => 'third_domain',
                'que_index' => 1,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Por favor, avalie de zero a dez o seu grau de disposição',
                'que_domain' => 'third_domain',
                'que_index' => 2,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Por favor, avalie de zero a dez a rigidez do seu corpo',
                'que_domain' => 'third_domain',
                'que_index' => 3,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Por favor, avalie de zero a dez o seu sono',
                'que_domain' => 'third_domain',
                'que_index' => 4,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Por favor, avalie de zero a dez o seu nível de depressão',
                'que_domain' => 'third_domain',
                'que_index' => 5,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Por favor, avalie de zero a dez o seu nível de memória',
                'que_domain' => 'third_domain',
                'que_index' => 6,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Por favor, avalie de zero a dez o seu nível de ansiedade',
                'que_domain' => 'third_domain',
                'que_index' => 7,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Por favor, avalie de zero a dez o seu nível de sensibilidade à dor',
                'que_domain' => 'third_domain',
                'que_index' => 8,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Por favor, avalie de zero a dez o seu nível de equilíbrio',
                'que_domain' => 'third_domain',
                'que_index' => 9,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Por favor, avalie de zero a dez o seu nível de sensibilidade, levando em consideração: rúidos altos, luzes fortes, cheiros ou frio',
                'que_domain' => 'third_domain',
                'que_index' => 10,
                'created_at' => now(),
            ],
            //? Micro Daily
            [
                'que_name' => 'Nível de dor',
                'que_domain' => 'micro_daily',
                'que_index' => 1,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Nível de Fadiga (Energia)',
                'que_domain' => 'micro_daily',
                'que_index' => 2,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Qualidade do Sono',
                'que_domain' => 'micro_daily',
                'que_index' => 3,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Nível de Humor/Ansiedade',
                'que_domain' => 'micro_daily',
                'que_index' => 4,
                'created_at' => now(),
            ],
            [
                'que_name' => 'Tomou os Medicamentos',
                'que_domain' => 'micro_daily',
                'que_index' => 5,
                'created_at' => now(),
            ],
        ]);
    }
}
