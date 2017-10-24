<?php

namespace Modules\Contact\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Models\Item;

class ItemsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $items = [
            [
                'type'  => 'phone',
                'value' => '+371-12345678'
            ],
            [
                'type'  => 'email',
                'value' => 'info@admin.com'
            ],
            [
                'type'  => 'location',
                'value' => 'Kr. Barona 111. Rīga, Latvia Lv4601'
            ],
            [
                'type'  => 'contact-email',
                'value' => 'contact@admin.com'
            ],
            [
                'type'  => 'workdays',
                'value' => '{"Monday - Friday":"09:00 - 18:00","Saturday":"09:00 - 15:00","Sunday":"Closed"}'
            ],
        ];

        foreach($items as $item) {
            Item::firstOrCreate($item);
        }
    }
}
