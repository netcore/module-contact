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
                'lat'      => '56.5000479',
                'lng'      => '27.3296318',
                'address'  => 'Rēzekne',
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
