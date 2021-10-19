<?php

namespace Database\Seeders;

use App\Models\Hub;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class HubLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hubs = [
            [
                'id' => 1,
                'name' => 'NCR',
                'description' => 'NCR HUB',
            ],
            [
                'id' => 2,
                'name' => 'EDL NCR',
                'description' => 'EDL NCR HUB',
            ],
            [
                'id' => 3,
                'name' => 'DAVAO DE ORO',
                'description' => 'DAVAO DE ORO HUB',
            ],
            [
                'id' => 4,
                'name' => 'DAVAO',
                'description' => 'DAVAO HUB',
            ],
            [
                'id' => 5,
                'name' => 'SOX',
                'description' => 'SOCCSKSARGEN HUB',
            ],
        ];

        foreach ($hubs as $hub) {
            $hubObject = Hub::firstOrCreate(['id' => $hub['id']], $hub);
            if (!$hubObject->wasRecentlyCreated) {
                $hubObject->update(Arr::only($hub, ['name', 'description']));
            }
        }
    }
}
