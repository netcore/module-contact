<?php

namespace Modules\Contact\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Translations\ItemTranslation;
use Modules\Form\Models\Form;
use Modules\Translate\Traits\SyncTranslations;

class Item extends Model
{
    use Translatable, SyncTranslations;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'netcore_contact__items';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'default_value',
        'type',
        'is_translateable'
    ];

    /**
     * @var string
     */
    public $translationModel = ItemTranslation::class;

    /**
     * @var array
     */
    public $translatedAttributes = [
        'value'
    ];

    /**
     * @var array
     */
    protected $with = ['translations'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function form()
    {
        return $this->belongsTo(Form::class, 'default_value');
    }
}
