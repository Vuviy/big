<?php

namespace WezomCms\Core\Foundation\Widgets;

use App;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;

class Widget
{
    protected static $views = [];

    /**
     * @var App
     */
    protected $app;

    /**
     * @var array
     */
    protected $widgets = [];

    /**
     * Widget constructor.
     * @param $app Application
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->widgets = config('cms.core.widgets.widgets', []);
    }

    /**
     * @param  string  $name
     * @param  mixed  $class
     * @return $this
     */
    public function register($name, $class)
    {
        $this->widgets[$name] = $class;

        return $this;
    }

    /**
     * @param  string  $name  - Widget name.
     * @param  array  $data
     * @param  string|null  $view
     * @return mixed|string
     * @throws \Throwable
     */
    public function show(string $name, array $data = [], ?string $view = null)
    {
        $this->startProfile($name);

        try {
            $widget = $this->makeWidgetInstance($name, $data, $view);

            if ($widget === null) {
                return '';
            }

            $this->startProfile($name . ':execute');
            $result = $this->execute($widget, $data);
            $this->stopProfile($name . ':executed');

            if (!empty($result)) {
                return $result;
            }

            return '';
        } catch (\Throwable $e) {
            report($e);
            if (config('app.debug')) {
                throw $e;
            }
        } finally {
            $this->stopProfile($name);
        }

        return '';
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getWidgets()
    {
        return $this->widgets;
    }

    /**
     * @param $name
     * @return bool
     */
    public function registered($name): bool
    {
        return array_key_exists($name, $this->widgets);
    }

    /**
     * @param  string  $name
     * @param  array  $data
     * @param  string|null  $view
     * @return AbstractWidget|null
     */
    private function makeWidgetInstance(string $name, array $data = [], ?string $view = null): ?AbstractWidget
    {
        if (!isset($this->widgets[$name])) {
            return null;
        }

        $widget = $this->app->make($this->widgets[$name]);

        if (!$widget instanceof AbstractWidget) {
            return null;
        }

        $widget->setData($data);

        if (null !== $view) {
            $widget->setView($view);
        }

        return $widget;
    }

    private function execute(AbstractWidget $widget, array $data = []): ?string
    {
        $cacheStorage = $this->cacheStorage($widget);

        if (self::isValidEnv() && ($widget->cacheTime || !empty($widget::$models))) {
            $cacheKey = $this->getCacheKey($widget, $data);

            if ($cacheStorage->has($cacheKey)) {
                return $cacheStorage->get($cacheKey);
            }
        }

        $viewPath = $widget->getView();
        if (!isset(static::$views[$viewPath])) {
            static::$views[$viewPath] = view($viewPath);
        }

        if (method_exists($widget, 'execute')) {
            $executed = $this->app->call([$widget, 'execute']);

            if (is_null($executed)) {
                return null;
            }

            $view = (clone static::$views[$viewPath])->with(array_merge($data, $executed))->render();
        } else {
            $view = (clone static::$views[$viewPath])->with(array_merge($data))->render();
        }

        // Cache rendered view
        if ($widget->cacheTime && self::isValidEnv()) {
            return $cacheStorage->remember($cacheKey, $widget->cacheTime * 60, function () use ($view) {
                return $view;
            });
        } elseif (!empty($widget::$models) && self::isValidEnv()) {
            return $cacheStorage->rememberForever($cacheKey, function () use ($view) {
                return $view;
            });
        }

        return $view;
    }

    /**
     * @param  AbstractWidget  $widget
     * @param  array  $data
     * @return string
     * @throws \Exception
     */
    protected function getCacheKey(AbstractWidget $widget, array $data)
    {
        $data = $this->serializeWidgetArguments($data);

        $data['class'] = get_class($widget);
        $data['locale'] = app()->getLocale();
        $data['view'] = $widget->getView();

        sort($data);

        return 'core.widgets.' . sha1(json_encode($data));
    }

    /**
     * Serialize widget arguments.
     *
     * @param  array|iterable|Arrayable|Collection  $data
     * @return array
     */
    private function serializeWidgetArguments($data): array
    {
        foreach ($data as $key => $value) {
            if ($value instanceof Arrayable) {
                $value = $value->toArray();
            } elseif (is_iterable($value)) {
                $value = $this->serializeWidgetArguments($value);
            }

            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * @param  AbstractWidget  $widget
     * @return Repository
     */
    protected function cacheStorage(AbstractWidget $widget): Repository
    {
        /** @var Repository $cache */
        $cache = $this->app['cache.store'];

        if (method_exists($cache->getStore(), 'tags')) {
            return $cache->tags(get_class($widget), 'widget');
        }

        return $cache;
    }

    protected static function isValidEnv()
    {
        return App::environment(['production', 'staging']);
    }

    /**
     * @param  string  $name
     */
    protected function startProfile(string $name)
    {
        if (function_exists('start_measure')) {
            start_measure($name);
        }
    }

    /**
     * @param  string  $name
     */
    protected function stopProfile(string $name)
    {
        if (function_exists('stop_measure')) {
            stop_measure($name);
        }
    }
}
