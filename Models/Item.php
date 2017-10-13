<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Form\Models\Form;

class Item extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'netcore_contact__items';

    protected $fillable = ['value', 'type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function form()
    {
        return $this->belongsTo(Form::class, 'value');
    }
}
