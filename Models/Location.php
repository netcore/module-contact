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

    protected $fillable = ['address', 'country', 'city', 'zip_code', 'lat', 'lng'];
}
