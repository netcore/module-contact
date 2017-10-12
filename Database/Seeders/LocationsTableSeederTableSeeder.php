<?php

namespace Modules\Contact\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Models\Location;

class LocationsTableSeederTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $locations = [
            [
                'lat'      => '56.5130713',
                'lng'      => '27.3348303',
                'address_full'  => 'Atbrīvošanas aleja, Rēzekne',
                'address_short'  => 'Atbrīvošanas aleja',
                'country'  => 'Latvia',
                'city'     => 'Rēzekne',
                'zip_code' => 'LV4601',
            ]
        ];

        foreach($locations as $location) {
            Location::firstOrCreate($location);
        }
    }
}
