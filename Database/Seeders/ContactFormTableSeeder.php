<?php

namespace Modules\Contact\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Models\Item;
use Modules\Form\Models\Form;

class ContactFormTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $fields = config('netcore.module-contact.form-data');

        $form = Form::firstOrCreate([
            'key'  => 'contact-us',
            'name' => 'Contact us',
        ]);

        $i = 0;
        foreach ($fields as $field) {
            $field['order'] = $i + 1;
            $formField = $form->fields()->firstOrCreate(array_only($field, ['key', 'type']), array_except($field, 'translations'));

            $formField->storeTranslations($field['translations']);
        }

        Item::firstOrCreate([
            'type'             => 'contact-form',
            'default_value'    => $form->id,
            'is_translateable' => 0
        ]);
    }
}
