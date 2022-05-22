<?php

namespace WezomCms\Core\Foundation\Dashboard;

use Cache;
use Gate;

abstract class AbstractValueDashboard extends AbstractDashboardWidget
{
    /**
     * Widget view path.
     *
     * @var string
     */
    public $view = 'cms-core::admin.dashboard.widgets.value';

    /**
     * @var null|int - cache time in minutes.
     */
    protected $cacheTime;

    /**
     * @var null|string - permission for link
     */
    protected $ability;

    /**
     * @return int
     */
    abstract public function value(): int;

    /**
     * @return string
     */
    abstract public function description(): string;

    /**
     * @return mixed
     */
    protected function icon(): string
    {
        return 'fa-info-circle';
    }

    /**
     * @return string
     */
    protected function iconColorClass(): string
    {
        return 'color-primary';
    }

    /**
     * @return string
     */
    protected function iconColor(): string
    {
        return '';
    }

    /**
     * @return null|string
     */
    protected function url(): ?string
    {
        return null;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function render()
    {
        if ($this->ability && Gate::denies($this->ability)) {
            return null;
        }

        if ($this->cacheTime && app()->isProduction()) {
            $value = Cache::remember(static::class, now()->addMinutes($this->cacheTime), function () {
                return $this->value();
            });
        } else {
            $value = $this->value();
        }

        return view($this->view, [
            'value' => $value,
            'description' => $this->description(),
            'icon' => $this->icon(),
            'iconColorClass' => $this->iconColorClass(),
            'iconColor' => $this->iconColor(),
            'url' => $this->url(),
        ])->render();
    }
}
