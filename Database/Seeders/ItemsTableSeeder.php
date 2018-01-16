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

        $items = config('netcore.module-contact.items');

        foreach ($items as $item) {
            $i = Item::create([
                'type'             => $item['type'],
                'is_translateable' => 1
            ]);

            foreach (TransHelper::getAllLanguages() as $language) {
                $i->storeTranslations([$language->iso_code => array_only($item, ['value'])]);
            }
        }
    }
}
