<?php
namespace Modules\Contact\Translations;


use Illuminate\Database\Eloquent\Model;

class LocationTranslation extends Model
{

    protected $table = 'netcore_contact__location_translations';
    /**
     * @var array
     */
    protected $fillable = [
        'address_full',
        'address_short',
        'country',
        'city',
        'zip_code',
        'lat',
        'lng',
        'locale' // This is very important
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
