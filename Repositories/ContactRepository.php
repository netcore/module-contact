<?php

namespace Modules\Contact\Repositories;


use Modules\Contact\Models\Content;
use Modules\Contact\Models\Item;
use Modules\Contact\Models\Location;

class ContactRepository
{

    /**
     * @var mixed|null
     */
    protected $cachedItems = null;

    /**
     * @var \Illuminate\Config\Repository|mixed|null
     */
    protected $cacheKey = null;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $config;

    /**
     * ContactRepository constructor.
     */
    public function __construct()
    {
        $this->config = config('netcore.module-contact');
        $this->cacheKey = $this->config['items_cache_key'];
        $this->cachedItems = cache()->rememberForever($this->cacheKey, function () {
            return Item::all();
        });
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
     * @param null $default
     * @return array|null|string
     */
    public function item($key = null, $default = null)
    {
        if (!$this->config['information']['enabled']) {
            return 'Getting information is disabled';
        }

        if ($key == 'maps_api_key') {
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
            $items = $this->cachedItems->whereNotIn('type', $disabledItems)->get();

            return $items;
        }

        if (in_array($key, $disabledItems)) {
            return $default;
        }

        $item = $this->cachedItems->where('type', $key)->first();
        if ($item) {
            if ($key == 'contact-form') {
                return $item->default_value;
            } else {
                return $item->value;
            }
        }

        return $default;
    }

    /**
     * @return string
     */
    public function content()
    {
        if (!$this->config['text-block']) {
            return 'Getting text is disabled';
        }

        $content = Content::first();

        return $content->text;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function clear_cache()
    {
        return cache()->forget($this->cacheKey);
    }
}
