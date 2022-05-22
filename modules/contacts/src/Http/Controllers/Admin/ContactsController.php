<?php

namespace WezomCms\Contacts\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Contacts\Http\Requests\Admin\ContactRequest;
use WezomCms\Contacts\Models\Contact;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\Fields\Input;
use WezomCms\Core\Settings\Fields\Textarea;
use WezomCms\Core\Settings\MetaFields\SeoFields;
use WezomCms\Core\Settings\RenderSettings;
use WezomCms\Core\Settings\Tab;
use WezomCms\Core\Traits\SettingControllerTrait;

class ContactsController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-contacts::admin';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.contacts';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = ContactRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-contacts::admin.Requests');
    }

    /**
     * @param  Builder  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->latest('created_at');
    }

    protected function settings(): array
    {
        // Site tab
        $siteSettings = RenderSettings::siteTab();

        $workTime = Textarea::make($siteSettings)
            ->setKey('work_time')
            ->setName(__('cms-contacts::admin.Work time'))
            ->setIsMultilingual()
            ->setRules('nullable')
            ->setRows(3)
            ->setSort(5);

        $result[] = SeoFields::make(__('cms-contacts::admin.Contacts'), [$workTime], null, 10);

        // Phones tab
        $phones = new RenderSettings(new Tab('phones', __('cms-contacts::admin.Phones'), 2));

        $result[] = Input::make($phones)
            ->setKey('social_phone')
            ->setName(__('cms-contacts::admin.Social phone'))
            ->setRules('nullable')
            ->setSort(2);

        $result[] = Input::make($phones)
            ->setKey('free_phone')
            ->setName(__('cms-contacts::admin.Free phone'))
            ->setRules('nullable')
            ->setSort(3);

        $result[] = Textarea::make($phones)
            ->setKey('phones')
            ->setName(__('cms-contacts::admin.Extra phones'))
            ->setRules('nullable')
            ->setRows(3)
            ->setSort(4);

        // Social tab
        $social = new RenderSettings(new Tab('social', __('cms-contacts::admin.Social networks'), 3));

        $result[] = $this->makeSocialInput($social, 'instagram', __('cms-contacts::admin.Instagram'), 1);
        $result[] = $this->makeSocialInput($social, 'telegram', __('cms-contacts::admin.Telegram'), 2);
        $result[] = Input::make($social)->setKey('viber')->setName(__('cms-contacts::admin.Viber'))->setSort(3)->setRules('nullable');
        $result[] = $this->makeSocialInput($social, 'facebook', __('cms-contacts::admin.Facebook'), 4);

        return $result;
    }

    /**
     * @param  RenderSettings  $renderSettings
     * @param  string  $key
     * @param  string  $name
     * @param  int  $sort
     * @return AbstractField
     */
    private function makeSocialInput(
        RenderSettings $renderSettings,
        string $key,
        string $name,
        int $sort = 0
    ): AbstractField {
        return Input::make($renderSettings)
            ->setKey($key)
            ->setName($name)
            ->setSort($sort)
            ->setRules('nullable|url');
    }
}
