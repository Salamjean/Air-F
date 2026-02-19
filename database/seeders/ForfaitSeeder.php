<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForfaitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $forfaits = [
            [
                'name' => 'F1',
                'label' => 'Intervention à la journée sur les sites de SAINT DENIS et PANTIN (avec déplacement) : J+14',
                'price' => 490.00,
                'tasks' => [
                    'Déplacement sur les deux Datacenters',
                    'Récupération et déballage d\'équipements (évacuation des emballages dans containers prévus à cet effet)',
                    'Installation d\'équipements',
                    'Installation câblages',
                    'Identification par scanning des QR codes assignés à chaque fibre, chaque asset et chaque ligne d\'alimentation',
                    'Contact et/ou photos de fin de prestation',
                ]
            ],
            [
                'name' => 'F2',
                'label' => 'Intervention en urgence (H+2) sur les sites de SAINT DENIS et PANTIN (avec déplacement)',
                'price' => 240.00,
                'tasks' => [
                    'Se rendre sur place et effectuer un contrôle visuel ou un reboot physique d\'équipement',
                    'Ce forfait est basé d\'une durée moyenne de 3h',
                ]
            ],
            [
                'name' => 'F3',
                'label' => 'Intervention J+ 1 (le lendemain) sur les sites de SAINT DENIS et PANTIN (avec déplacement)',
                'price' => 298.00,
                'tasks' => [
                    'Se rendre sur place et effectuer un contrôle visuel, un reboot physique d\'équipement ou une petite installation (1/2 cablages)',
                    'Ce forfait est basé sur une intervention d\'une demi-journée',
                ]
            ],
            [
                'name' => 'F4',
                'label' => 'Forfait Logistique',
                'price' => 309.00,
                'tasks' => [
                    'Récupération du matériel au Bâtiment Les Scientifiques à Roissy CDG ou au Bâtiment 3 AFI à Orly',
                    'Acheminement du matériel sur les sites de Pantin et Saint-Denis',
                    'Mise à disposition d\'un véhicule adapté',
                ]
            ],
        ];

        foreach ($forfaits as $data) {
            $tasks = $data['tasks'];
            unset($data['tasks']);

            $forfait = \App\Models\Forfait::updateOrCreate(['name' => $data['name']], $data);

            foreach ($tasks as $taskDesc) {
                \App\Models\ForfaitTask::updateOrCreate([
                    'forfait_id' => $forfait->id,
                    'description' => $taskDesc
                ]);
            }
        }
    }
}
