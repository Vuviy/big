<?php

namespace WezomCms\Core\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;

class ApiController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @var array
     */
    protected $locales;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->locales = array_keys(app('locales'));
    }

    /**
     * @param  Request|array  $input
     * @param  array  $attributes
     * @return array
     */
    protected function prepareLocalizedAttributes($input, array $attributes): array
    {
        $input = $input instanceof Request ? $input->all() : $input;

        $result = [];

        foreach ($this->locales as $locale) {
            $data = [];
            foreach ($attributes as $attribute) {
                $data[$attribute] = Arr::get($input, "lang.{$locale}.{$attribute}");
            }

            $result[$locale] = $data;
        }

        return $result;
    }
}
