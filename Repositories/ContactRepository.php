<?php

namespace Modules\Contact\Repositories;


use Modules\Contact\Models\Content;
use Modules\Contact\Models\Item;
use Modules\Contact\Models\Location;

class ContactRepository
{

    private $config;

    /**
     * ContactRepository constructor.
     */
    public function __construct()
    {
        $this->config = config('netcore.module-contact');
    }

    /**
     * @return mixed
     */
    public function map()
    {
        if (!$this->config['map']) {
            return 'Map is disabled';
        }

        return Location::first();
    }

    /**
     * @param null $key
     * @return array|null|string
     */
    public function item($key = null)
    {
        if (!$this->config['information']['enabled']) {
            return 'Getting information is disabled';
        }

        if($key == 'maps_api_key') {
            return config('netcore.module-contact.maps_api_key');
        }

        $items = array_except($this->config['information'], 'enabled');
        $disabledItems = [];
        foreach ($items as $item => $state) {
            if (!$state) {
                $disabledItems[] = $item;
            }
        }

        if (!$key) {
            $items = Item::whereNotIn('type', $disabledItems)->get();

            return $items;
        }

        if (in_array($key, $disabledItems)) {
            return null;
        }

        $item = Item::whereType($key)->first();


        if ($item) {
            if ($key == 'contact-form') {
                return $item->default_value;
            } else {
                return $item->value;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public
    function content()
    {
        if (!$this->config['text-block']) {
            return 'Getting text is disabled';
        }

        $content = Content::first();

        return $content->text;
    }
}