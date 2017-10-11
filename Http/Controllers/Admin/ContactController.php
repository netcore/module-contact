<?php

namespace Modules\Contact\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Contact\Models\Content;
use Modules\Contact\Models\Item;
use Modules\Contact\Models\Location;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $items = Item::get();
        $content = Content::first();
        $location = Location::first();

        return view('contact::index', compact('items', 'content', 'location'));
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
}
