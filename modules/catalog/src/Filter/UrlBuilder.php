<?php

namespace WezomCms\Catalog\Filter;

use Illuminate\Http\Request;
use WezomCms\Catalog\Filter\Contracts\UrlBuilderInterface;

class UrlBuilder implements UrlBuilderInterface
{
    protected const SPECS_DELIMITER = ';';
    protected const KEY_VAL_DELIMITER = '=';
    protected const VALUES_DELIMITER = ',';

    /**
     * @var UrlBuilder|null
     */
    private static $instance;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $routeName;

    /**
     * @var string
     */
    private $emptyRouteName;

    /**
     * @var array
     */
    private $routeParameters = [];

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * UrlBuilder constructor.
     * @param  string|null  $routeName
     * @param  string|null  $emptyRouteName
     */
    public function __construct(?string $routeName = 'catalog.filter', ?string $emptyRouteName = 'catalog')
    {
        if ($routeName !== null) {
            $this->setRouteName($routeName);
        }

        if ($emptyRouteName !== null) {
            $this->setEmptyRouteName($emptyRouteName);
        }
    }

    /**
     * @param  null|string  $routeName
     * @param  null|string  $emptyRouteName
     * @return null|UrlBuilder
     */
    public static function getInstance(?string $routeName = 'catalog.filter', ?string $emptyRouteName = 'catalog')
    {
        if (null === static::$instance) {
            static::$instance = new static($routeName, $emptyRouteName);
        }

        return static::$instance;
    }

    /**
     * @param  string  $name
     * @return UrlBuilderInterface
     */
    public function setRouteName(string $name): UrlBuilderInterface
    {
        $this->routeName = $name;

        return $this;
    }

    /**
     * @param  array  $parameters
     * @return UrlBuilder
     */
    public function setRouteParameters(array $parameters = [])
    {
        $this->routeParameters = $parameters;

        return $this;
    }

    /**
     * @param  string  $name
     * @return UrlBuilderInterface
     */
    public function setEmptyRouteName(string $name): UrlBuilderInterface
    {
        $this->emptyRouteName = $name;

        return $this;
    }

    /**
     * @param  Request  $request
     * @return UrlBuilder
     */
    public function setRequest(Request $request): UrlBuilder
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return UrlBuilderInterface
     */
    public function start(): UrlBuilderInterface
    {
        $specs = explode(static::SPECS_DELIMITER, $this->request->route('filter'));
        $specs = array_filter($specs);
        foreach ($specs as $spec) {
            $parts = explode(static::KEY_VAL_DELIMITER, $spec, 2);

            $explodedValues = explode(static::VALUES_DELIMITER, array_get($parts, 1, ''));
            $this->parameters[array_get($parts, 0)] = array_filter($explodedValues);
        }

        return $this;
    }

    /**
     * @param  array|null  $keys
     * @return iterable
     */
    public function getParameters(array $keys = null): iterable
    {
        if (null !== $keys) {
            return array_intersect_key($this->parameters, array_flip($keys));
        }

        return $this->parameters;
    }

    /**
     * @return string|null
     */
    public function getOriginalUrl(): ?string
    {
        return $this->request->fullUrl();
    }

    /**
     * @param $key
     * @param $value
     * @return UrlBuilderInterface
     */
    public function add($key, $value): UrlBuilderInterface
    {
        array_set($this->parameters, $key, $value);

        return $this;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function present($key, $value): bool
    {
        if (!isset($this->parameters[$key])) {
            return false;
        }

        return in_array($value, $this->parameters[$key]);
    }

    /**
     * @param  iterable  $parameters
     * @return string
     */
    public static function buildFromArray(iterable $parameters = []): string
    {
        $builder = static::getInstance();

        return $builder->generateRoute($builder->build($parameters));
    }

    /**
     * @param  iterable  $parameters
     * @return string|null
     */
    public function build(iterable $parameters = []): ?string
    {
        $parameters = $this->clear($parameters);

        $joinedValues = [];
        foreach ($parameters as $key => $values) {
            sort($values);
            $joinedValues[$key] = implode(static::VALUES_DELIMITER, $values);
        }

        ksort($joinedValues);

        $parts = [];
        foreach ($joinedValues as $key => $values) {
            $parts[] = $key . static::KEY_VAL_DELIMITER . $values;
        }

        return implode(static::SPECS_DELIMITER, $parts);
    }

    /**
     * @param $key
     * @param $value
     * @return string
     */
    public function autoBuild($key, $value): string
    {
        if ($this->present($key, $value)) {
            return $this->buildUrlWithout($key, $value);
        } else {
            return $this->buildUrlWith($key, $value);
        }
    }

    /**
     * @param $key
     * @param $value
     * @return string
     */
    public function buildUrlWith($key, $value): string
    {
        $parameters = $this->parameters;

        if (!isset($parameters[$key])) {
            $parameters[$key] = [];
        }

        $parameters[$key][] = $value;

        return $this->generateRoute($this->build($parameters));
    }

    /**
     * @param  string|array  $key
     * @param  mixed|null  $value
     * @return string
     */
    public function buildUrlWithout($key, $value = null): string
    {
        $parameters = $this->parameters;

        if (is_array($key)) {
            $remove = $key;
        } else {
            $remove[$key] = $value;
        }

        foreach ($remove as $removeKey => $removeValue) {
            if (isset($parameters[$removeKey])) {
                foreach ((array) $removeValue as $removal) {
                    $position = array_search($removal, $parameters[$removeKey]);
                    if ($position !== false) {
                        unset($parameters[$removeKey][$position]);
                    }
                }
            }
        }

        return $this->generateRoute($this->build($parameters));
    }

    /**
     * @param $key
     * @param  null  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_get($this->parameters, $key, $default);
    }

    /**
     * Extract first value.
     *
     * @param $key
     * @param  null  $default
     * @return mixed
     */
    public function first($key, $default = null)
    {
        return array_first(array_get($this->parameters, $key, $default));
    }

    /**
     * @param $key
     * @return bool
     */
    public function remove($key): bool
    {
        if (isset($this->parameters[$key])) {
            unset($this->parameters[$key]);

            return true;
        }

        return false;
    }

    /**
     * @param  iterable  $parameters
     * @return array
     */
    private function clear(iterable $parameters)
    {
        foreach ($parameters as $key => &$values) {
            $values = array_filter((array) $values);
        }

        return array_filter((array) $parameters);
    }

    /**
     * @param  string|null  $filterUrl
     * @return string
     */
    private function generateRoute(?string $filterUrl)
    {
        $queryString = $this->request->getQueryString();
        $queryString = $queryString ? '?' . $queryString : '';

        if ($filterUrl) {
            return route($this->routeName, array_merge($this->routeParameters, ['filter' => $filterUrl])) . $queryString;
        } else {
            return route($this->emptyRouteName, $this->routeParameters) . $queryString;
        }
    }
}
