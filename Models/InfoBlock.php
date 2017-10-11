<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;

class InfoBlock extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'netcore_contact__info_blocks';

    protected $fillable = ['order', 'is_active'];
}
