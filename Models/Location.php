<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'netcore_contact__locations';

    protected $fillable = ['address_full', 'address_short', 'country', 'city', 'zip_code', 'lat', 'lng'];
}
