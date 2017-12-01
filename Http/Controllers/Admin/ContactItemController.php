<?php

namespace Modules\Contact\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Contact\Http\Requests\ItemRequest;
use Modules\Contact\Http\Requests\ItemUpdateRequest;
use Modules\Contact\Models\Item;

class ContactItemController extends Controller
{

    /**
     * @param Item $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Item $item)
    {
        return view('contact::item.edit', compact('item'));
    }

    /**
     * @param ItemUpdateRequest $request
     * @param Item              $item
     * @return mixed
     */
    public function updateItem(ItemUpdateRequest $request, Item $item)
    {
        $item->updateTranslations($request->get('translations', []));

        contact()->clear_cache();

        return redirect()->back()->withSuccess('Item successfully edited!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ItemRequest $request
     * @return array
     */
    public function update(ItemRequest $request)
    {
        $item = Item::find($request->get('item_id', null));
        if (!$item) {
            abort(404);
        }

        if ($item->type != 'workdays') {
            $item->default_value = $request->get('value');
        } else {
            $workdays = collect(json_decode($item->default_value))->toArray();

            $newWorkDays = [];
            $i = 0;
            foreach ($workdays as $day => $time) {
                $newWorkDays[$day] = $request->get('value', [])[$i];
                $i++;
            }
            $item->value = json_encode($newWorkDays);
        }
        $item->save();

        return [
            'data' => $item,
            'json' => $item->toJson()
        ];
    }
}
