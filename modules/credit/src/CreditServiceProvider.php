<?php

namespace WezomCms\Credit;

use Event;
use Illuminate\Console\Command;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\Assets\AssetManagerInterface;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Contracts\SitemapXmlGeneratorInterface;
use WezomCms\Credit\Database\Seeders\CreditPaymentSeeder;
use WezomCms\Credit\Drivers\Credit;
use WezomCms\Credit\Enums\CreditType;
use WezomCms\Credit\Listeners\SendCreditRequest;
use WezomCms\Credit\Services\CreditService;
use WezomCms\Orders\Events\CreatedOrder;
use WezomCms\Orders\Models\Payment;

class CreditServiceProvider extends BaseServiceProvider
{
    /**
     * Custom translation keys.
     *
     * @var array
     */
    protected $translationKeys = [
        'cms-credit::admin.home_credit_bank',
    ];

    /**
     * List of enum classes for auto scanning localization keys.
     *
     * @var array
     */
    protected $enumClasses = [CreditType::class];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CreditService::class);
    }

    /**
     * Application booting.
     */
    public function boot()
    {
        parent::boot();

        Payment::addDriver('credit', Credit::class);

        $this->app->booted(function () {
            Event::listen(CreatedOrder::class, SendCreditRequest::class);
        });
    }

    protected function afterBootForAdminPanel()
    {
        app(AssetManagerInterface::class)
            ->addJs('vendor/cms/credit/credit.js', 'credit')
            ->group(AssetManagerInterface::GROUP_ADMIN);
    }

    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.credit.credit.widgets';

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->editSettings('credit', __('cms-credit::admin.Edit credit settings'));

        $permissions->add('home-credit-coefficients', __('cms-credit::admin.HomeCredit coefficients'))
            ->withEditSettings();
    }

    /**
     * Register all admin sidebar menu links.
     */
    public function adminMenu()
    {
        $credit = \SidebarMenu::add(__('cms-credit::admin.Credit'))
            ->data('icon', 'fa-money')
            ->data('position', 30)
            ->nickname('credit');

        $credit->add(__('cms-credit::admin.HomeCredit coefficients'), route('admin.home-credit-coefficients.index'))
            ->data('permission', 'home-credit-coefficients.view')
            ->data('icon', 'fa-bar-chart-o')
            ->data('position', 2);

        $credit->add(__('cms-core::admin.layout.Settings'), route('admin.credit.settings'))
            ->data('icon', 'fa-cog')
            ->data('position', 4);
    }


    /**
     * @return array
     */
    public function sitemap()
    {
        return [
            [
                'sort' => 10,
                'parent_id' => 0,
                'url' => route('credit-and-installment'),
                'name' => settings('credit.site.name'),
            ]
        ];
    }

    /**
     * @param  SitemapXmlGeneratorInterface  $sitemap
     */
    public function sitemapXml(SitemapXmlGeneratorInterface $sitemap)
    {
        $sitemap->addLocalizedRoute('credit-and-installment');
    }

    /**
     * Register module listeners.
     */
    protected function registerListeners()
    {
        parent::registerListeners();

        Event::listen('information-menu:services', function () {
            return [
                'route' => 'credit-and-installment',
                'name' => __('cms-credit::site.Credit and installment'),
                'position' => 5,
            ];
        });

        if ($this->app->runningInConsole()) {
            Event::listen('cms:install:after_migrate', function (Command $command) {
                if (
                    Payment::where('driver', Credit::DRIVER)->doesntExist()
                    && $command->confirm('Do your want run seed "Create credit payment variant"', 'yes')
                ) {
                    $command->call('db:seed', [
                        '--class' => CreditPaymentSeeder::class,
                        '--force' => $command->option('force'),
                    ]);
                }
            });
        }
    }
}
