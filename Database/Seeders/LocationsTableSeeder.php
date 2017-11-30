<?php

namespace Modules\Contact\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Models\Location;

class LocationsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $locations = config('netcore.module-contact.location-data');
        $l = Location::create(['is_active' => 1]);
        foreach($locations as $isoCode => $location) {
            $l->storeTranslations([$isoCode => $location]);
        }
    }
}
