<?php

namespace Modules\Contact\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Models\Content;

class ContentTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempor bibendum tincidunt. Mauris molestie neque quis augue sodales consequat id ut diam. Nunc consequat rhoncus dolor, sit amet vestibulum lacus viverra ac. 
        Suspendisse placerat orci eu ipsum fermentum, quis blandit neque aliquam. Praesent bibendum vitae libero at scelerisque. 
        Nullam sit amet lacus placerat velit tempus rhoncus non interdum purus. Mauris condimentum congue imperdiet. Quisque facilisis, justo sit amet iaculis tristique, 
        
        ante risus semper justo, in dapibus velit felis eu nibh. Ut leo turpis, fringilla nec pulvinar sed, posuere eleifend leo. Maecenas efficitur efficitur metus, 
        eget pretium velit vulputate eget. Nunc efficitur ac est a efficitur. Aliquam hendrerit neque orci, sed scelerisque tortor tempor at. Integer commodo ipsum 
        t feugiat tincidunt. Aliquam rutrum sagittis purus sed vestibulum. Nullam consectetur scelerisque nisl, nec maximus est pellentesque vel.';

        $content = Content::first();

        if ($content) {
            $content->text = $text;
            $content->save();
        } else {
            Content::create([
                'text' => $text
            ]);
        }


    }
}
