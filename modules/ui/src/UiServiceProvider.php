<?php

namespace WezomCms\Ui;

use Blade;
use Illuminate\Pagination\Paginator;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Ui\Listeners\AddBreadcrumbsMicroData;
use WezomCms\Ui\Listeners\AssetsRegistrar;
use WezomCms\Ui\View\Components\PhoneInput;
use WezomCms\Ui\View\Components\Wysiwyg;
use WezomCms\Ui\View\Components\WysiwygMini;

class UiServiceProvider extends BaseServiceProvider
{
    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.ui.ui.widgets';

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'assets: js-site-head' => [
            AddBreadcrumbsMicroData::class,
        ],
        'assets: css-site-head' => [
            [AssetsRegistrar::class, 'addCssToHead'],
        ],
        'assets: js-site-end_body' => [
            [AssetsRegistrar::class, 'addJsToBody'],
        ],
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Ui::class);
    }

    /**
     * Load module views.
     */
    protected function views()
    {
        parent::views();

        if (!$this->app['isBackend']) {
            $paginationViews = config('cms.ui.ui.pagination', []);

            // Default view
            if ($defaultView = array_get($paginationViews, 'default')) {
                Paginator::defaultView($defaultView);
            }

            // Simple view
            if ($simpleView = array_get($paginationViews, 'simple')) {
                Paginator::defaultSimpleView($simpleView);
            }
        }

        $this->loadViewsFrom($this->root('resources/views/components'), 'ui-components');

        Blade::directive('svg', function ($arguments) {
            return '<?php echo svg(' . $arguments . '); ?>';
        });

        Blade::directive('emptyResult', function ($text) {
            if ($text) {
                return "<?php echo app('view')->make('cms-ui::empty-result', ['text' => $text]); ?>";
            }
            return "<?php echo app('view')->make('cms-ui::empty-result', ['text' => null]); ?>";
        });

        $this->loadViewComponentsAs('ui', [
            PhoneInput::class,
            Wysiwyg::class,
            WysiwygMini::class,
        ]);
    }
}
