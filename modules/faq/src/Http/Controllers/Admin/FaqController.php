<?php

namespace WezomCms\Faq\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\MetaFields\SeoFields;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\SiteLimit;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\Faq\Http\Requests\Admin\FaqRequest;
use WezomCms\Faq\Models\FaqGroup;
use WezomCms\Faq\Models\FaqQuestion;

class FaqController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = FaqQuestion::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-faq::admin.faq';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.faq';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = FaqRequest::class;

    /**
     * @var bool
     */
    private $useGroups;

    /**
     * FaqController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->useGroups = (bool) config('cms.faq.faq.use_groups');
    }

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-faq::admin.Questions');
    }

    /**
     * @return string|null
     */
    protected function frontUrl(): ?string
    {
        return route('faq');
    }

    /**
     * @param  Builder  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        if ($this->useGroups) {
            $query->with('group');
        }

        $query->sorting();
    }

    /**
     * @param  FaqQuestion  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function formData($obj, array $viewData): array
    {
        $data = [];

        if ($this->useGroups) {
            $data['groups'] = FaqGroup::getForSelect(true);
        }

        return $data;
    }

    /**
     * @param  FaqQuestion  $obj
     * @param  Request  $request
     */
    public function afterSuccessfulSave($obj, Request $request)
    {
        if ($this->useGroups) {
            $obj->group()->associate($request->get('faq_group_id'))->save();
        }
    }

    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        return [
            SiteLimit::make(),
            SeoFields::make('Faq'),
            AdminLimit::make(),
        ];
    }
}
