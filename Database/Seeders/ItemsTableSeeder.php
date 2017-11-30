<?php

namespace Modules\Contact\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Models\Item;
use Netcore\Translator\Helpers\TransHelper;

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
                'type'             => 'phone',
                'value'            => '+371-12345678',
                'is_translateable' => 1,
            ],
            [
                'type'             => 'email',
                'value'            => 'info@admin.com',
                'is_translateable' => 1,
            ],
            [
                'type'             => 'location',
                'value'            => 'Kr. Barona 111. Rīga, Latvia Lv4601',
                'is_translateable' => 1,
            ],
            [
                'type'             => 'contact-email',
                'value'            => 'contact@admin.com',
                'is_translateable' => 1,
            ],
            [
                'type'             => 'workdays',
                'value'            => '{"Monday - Friday":"09:00 - 18:00","Saturday":"09:00 - 15:00","Sunday":"Closed"}',
                'is_translateable' => 1,
            ],
        ];

        foreach ($items as $item) {
            $i = Item::create(array_except($item, ['value']));
            foreach (TransHelper::getAllLanguages() as $language) {
                $i->storeTranslations([$language->iso_code => array_except($item, ['type', 'is_translateable'])]);
            }
        }
    }
}
