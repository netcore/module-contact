<?php

namespace Modules\Contact\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Translations\LocationTranslation;
use Modules\Translate\Traits\SyncTranslations;

class Location extends Model
{
    use Translatable, SyncTranslations;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'netcore_contact__locations';

    protected $fillable = ['is_active'];

    /**
     * @var string
     */
    public $translationModel = LocationTranslation::class;

    /**
     * @var array
     */
    public $translatedAttributes = [
        'address_full',
        'address_short',
        'country',
        'city',
        'zip_code',
        'lat',
        'lng',
    ];

    /**
     * @var array
     */
    protected $with = ['translations'];
}
