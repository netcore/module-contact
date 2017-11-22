<?php

namespace Modules\Contact\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Contact\Http\Requests\LocationsRequest;
use Modules\Contact\Models\Content;
use Modules\Contact\Models\Item;
use Modules\Contact\Models\Location;
use Modules\Form\Models\Form;
use Nwidart\Modules\Facades\Module;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = Item::get()->map(function ($item) {

            // Patch posgresql
            if (is_numeric($item->default_value)) {
                $item->load('form');
            } else {
                $item->form = null;
            }

            return $item;
        });

        $content = Content::first();
        $location = Location::first();

        $module = Module::find('form');

        if ($module && $module->enabled()) {
            $forms = Form::all();
            $form = $forms->where('id', contact()->item('contact-form'))->first();
        }

        if (!$form) {
            return redirect()->to('/admin');
        }

        $config = config('netcore.module-contact');

        return view('contact::index', compact('items', 'content', 'location', 'forms', 'config', 'form'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateContent(Request $request)
    {
        $content = Content::first();

        $content->text = $request->get('text', '');
        $content->save();

        return redirect()->back()->withSuccess('Content text successfully edited!');
    }

    /**
     * @param LocationsRequest $request
     * @return mixed
     */
    public function updateMap(LocationsRequest $request)
    {
        $location = Location::first();

        $location->update($request->all());

        return redirect()->back()->withSuccess('Location data successfully updated!');
    }
}
