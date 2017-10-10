<?php

namespace Modules\Contact\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\Menu;
use Modules\Admin\Models\MenuItem;

class MenusTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $menus = [
            'leftAdminMenu' => [
                [
                    'name'       => 'Contact page',
                    'icon'       => 'fa-address-book',
                    'type'       => 'route',
                    'value'      => 'admin::contact.index',
                    'module'     => 'Contact',
                    'is_active'  => 1,
                    'parameters' => json_encode([]),
                ],
            ]
        ];

        foreach ($menus as $name => $items) {
            $menu = Menu::firstOrCreate([
                'name' => $name
            ]);


            foreach ($items as $item) {
                $item['menu_id'] = $menu->id;
                MenuItem::firstOrCreate(array_except($item, 'children'));
            }
        }
    }
}
