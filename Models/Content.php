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

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = ['text'];

    /**
     * Disable timestamps
     *
     * @var bool
     */
    public $timestamps = false;
}
