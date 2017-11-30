<?php
namespace Modules\Contact\Translations;


use Illuminate\Database\Eloquent\Model;

class ItemTranslation extends Model
{

    protected $table = 'netcore_contact__item_translations';
    /**
     * @var array
     */
    protected $fillable = [
        'value',
        'locale' // This is very important
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
