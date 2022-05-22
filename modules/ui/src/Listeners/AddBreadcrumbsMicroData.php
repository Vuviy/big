<?php

namespace WezomCms\Ui\Listeners;

use Spatie\SchemaOrg\Schema;
use WezomCms\Core\Contracts\Assets\AssetManagerInterface;
use WezomCms\Core\Contracts\BreadcrumbsInterface;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Traits\MicroDataTrait;
use WezomCms\Home\HomeServiceProvider;

class AddBreadcrumbsMicroData
{
    use MicroDataTrait;

    /**
     * @var AssetManagerInterface
     */
    private $assetManager;

    /**
     * @var BreadcrumbsInterface
     */
    private $breadcrumbsContainer;

    /**
     * Create the event listener.
     *
     * @param  AssetManagerInterface  $assetManager
     * @param  BreadcrumbsInterface  $breadcrumbsContainer
     */
    public function __construct(AssetManagerInterface $assetManager, BreadcrumbsInterface $breadcrumbsContainer)
    {
        $this->breadcrumbsContainer = $breadcrumbsContainer;
        $this->assetManager = $assetManager;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $breadcrumbs = collect();

        $position = 1;
        // Add home
        if (Helpers::providerLoaded(HomeServiceProvider::class)) {
            $breadcrumbs->push(Schema::listItem()
                ->position($position++)
                ->item(route('home'))
                ->name(settings('home.site.name', __('cms-home::site.Home'))));
        }

        foreach ($this->breadcrumbsContainer->getBreadcrumbs() as $breadcrumb) {
            $breadcrumbs->push(Schema::listItem()
                ->position($position++)
                ->item(array_get($breadcrumb, 'link'))
                ->name(array_get($breadcrumb, 'name')));
        }

        if ($breadcrumbs->isEmpty()) {
            return;
        }

        $this->renderMicroData(Schema::breadcrumbList()->itemListElement($breadcrumbs->toArray()));
    }
}
