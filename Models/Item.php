<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'netcore_contact__items';

    protected $fillable = ['value', 'type'];
}
