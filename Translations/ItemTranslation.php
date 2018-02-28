<?php

namespace Modules\Contact\Translations;

use Illuminate\Database\Eloquent\Model;

class ItemTranslation extends Model
{

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'netcore_contact__item_translations';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'locale' // This is very important
    ];

    /**
     * Disable timestamps
     *
     * @var bool
     */
    public $timestamps = false;
}
