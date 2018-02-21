<?php

namespace Modules\Contact\Tests;

use Modules\Contact\Models\Item;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    /** @test */
    public function guests_cannot_view_contacts_page()
    {
        $this->get(route('admin::contact.index'))->assertRedirect('admin/login');
    }

    /** @test */
    public function admins_can_view_contacts_page()
    {
        $user = app(config('netcore.module-admin.user.model'))->where('is_admin', 1)->first();
        $this->be($user);

        $this->get(route('admin::contact.index'))->assertStatus(200);
    }

    /** @test */
    public function guests_cannot_edit_contact_items()
    {
        $contactItem = Item::first();

        $this->get(route('admin::contact.item.edit', $contactItem))->assertRedirect('admin/login');
    }

    /** @test */
    public function admins_can_edit_contact_items()
    {
        $contactItem = Item::first();
        $user = app(config('netcore.module-admin.user.model'))->where('is_admin', 1)->first();
        $this->be($user);

        $this->get(route('admin::contact.item.edit', $contactItem))->assertStatus(200);
    }
}
