<?php

namespace Modules\Contact\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Nwidart\Modules\Facades\Module;

class ContactDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(MenusTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(ContentTableSeeder::class);
        $this->call(LocationsTableSeeder::class);

        $module = Module::find('form');

        if ($module && $module->enabled()) {
            $this->call(ContactFormTableSeeder::class);
        }
    }
}
