<?php

namespace Modules\Contact\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Contact\Http\Requests\ItemRequest;
use Modules\Contact\Models\Item;

class ContactItemController extends Controller
{


    /**
     * Update the specified resource in storage.
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
            $item->value = $request->get('value');
        } else {
            $workdays = collect(json_decode($item->value))->toArray();

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
