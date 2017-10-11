<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'netcore_contact__content';

    protected $fillable = ['text'];

    public $timestamps = false;
}
