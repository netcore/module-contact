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
                'meta'   => [
                    'attributes' => ['required'],
                    'options' => [],
                    'validation' => ['required', 'email'],
                ],
                'translations' => [
                    'en' => [
                        'label' => 'Name'
                    ]
                ]
            ],
            [
                'key'          => 'surname',
                'type'         => 'text',
                'meta'   => [
                    'attributes' => ['required'],
                    'options' => [],
                    'validation' => ['required'],
                ],
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
                'meta'   => [
                    'attributes' => ['required'],
                    'options' => [],
                    'validation' => ['required'],
                ],
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
        foreach ($fields as $i => $field) {
            $field['order'] = $i + 1;
            $formField = $form->fields()->firstOrCreate(array_except($field, 'translations'));
            $formField->storeTranslations($field['translations']);
        }

        Item::firstOrCreate([
            'type'  => 'contact-form',
            'value' => $form->id
        ]);
    }
}
