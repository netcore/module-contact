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

        $fields = [
            [
                'key'          => 'name',
                'type'         => 'text',
                'translations' => [
                    'en' => [
                        'label' => 'Name'
                    ]
                ]
            ],
            [
                'key'          => 'surname',
                'type'         => 'text',
                'translations' => [
                    'en' => [
                        'label' => 'Surname'
                    ]
                ]
            ],
            [
                'key'          => 'company',
                'type'         => 'text',
                'translations' => [
                    'en' => [
                        'label' => 'Company / Organization'
                    ]
                ]
            ],
            [
                'key'          => 'email',
                'type'         => 'text',
                'translations' => [
                    'en' => [
                        'label' => 'Email'
                    ]
                ]
            ],
            [
                'key'          => 'message',
                'type'         => 'textarea',
                'translations' => [
                    'en' => [
                        'label' => 'Message'
                    ]
                ]
            ],
        ];

        $form = Form::firstOrCreate([
            'key'        => 'contact-us',
            'name'       => 'Contact us',
        ]);

        $i = 1;
        foreach ($fields as $field) {
            $field['order'] = $i;
            $field['meta'] = '{"attributes":[]}';
            $formField = $form->fields()->firstOrCreate(array_except($field, 'translations'));
            $formField->storeTranslations($field['translations']);
            $i++;
        }

        Item::firstOrCreate([
            'type'  => 'contact-form',
            'value' => $form->id
        ]);
    }
}
