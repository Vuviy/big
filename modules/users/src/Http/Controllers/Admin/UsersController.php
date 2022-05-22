<?php

namespace WezomCms\Users\Http\Controllers\Admin;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\Fields\Input;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\PageName;
use WezomCms\Core\Settings\RenderSettings;
use WezomCms\Core\Settings\Tab;
use WezomCms\Core\Traits\AjaxResponseStatusTrait;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\Users\Http\Requests\Admin\CreateUserRequest;
use WezomCms\Users\Http\Requests\Admin\UpdateUserRequest;
use WezomCms\Users\Models\User;

class UsersController extends AbstractCRUDController
{
    use SettingControllerTrait;
    use AjaxResponseStatusTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-users::admin';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.users';

    /**
     * Form request class name for "create" action.
     *
     * @var string
     */
    protected $createRequest = CreateUserRequest::class;

    /**
     * Form request class name for "update" action.
     *
     * @var string
     */
    protected $updateRequest = UpdateUserRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-users::admin.Users');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function auth($id)
    {
        $user = User::findOrFail($id);

        Auth::guard('web')->login($user);

        return redirect()->route('cabinet');
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        /** @var Collection|User[] $users */
        $users = $this->model()::search($request->get('term'));

        $results = [];
        if (!$request->get('page')) {
            $results[] = ['id' => '', 'text' => __('cms-core::admin.layout.Not set')];
        }
        foreach ($users as $user) {
            $results[] = ['id' => $user->id, 'text' => $user->full_name];
        }

        return $this->success([
            'results' => $results,
            'pagination' => [
                'more' => $users->hasMorePages(),
            ]
        ]);
    }

    /**
     * @param  User  $obj
     * @param  FormRequest  $request
     * @return array
     */
    protected function fillStoreData($obj, FormRequest $request): array
    {
        $obj->password = bcrypt($request->get('password'));

        $this->fillEmailVerified($obj, $request);

        return $request->except('password');
    }

    /**
     * @param  User  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function formData($obj, array $viewData): array
    {
        return [
            'communicationTypes'     => User::communicationTypes(),
            'selectedCommunications' => $obj->selectedCommunications()
        ];
    }

    /**
     * @param  User  $obj
     * @param  FormRequest  $request
     * @return array
     */
    protected function fillUpdateData($obj, FormRequest $request): array
    {
        if ($password = $request->get('password')) {
            $obj->password = bcrypt($password);
        }

        $this->fillEmailVerified($obj, $request);

        return $request->except('password');
    }

    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        $result = [];

        $result[] = MultilingualGroup::make(
            new RenderSettings(new Tab('cabinet', __('cms-users::admin.Cabinet'), 1, 'fa-file-text')),
            [PageName::make()->default('cms-users::admin.Personal data')]
        );

        $this->addSocialSettings($result);

        $result[] = AdminLimit::make();

        return $result;
    }

    /**
     * @param  User  $obj
     * @param  Request  $request
     */
    private function fillEmailVerified($obj, Request $request)
    {
        if ($request->get('email_verified', false)) {
            if (!$obj->hasVerifiedEmail()) {
                $obj->email_verified_at = Date::now();
                $obj->temporary_code = null;
            }
        } else {
            $obj->email_verified_at = null;
        }
    }

    /**
     * @param  array  $result
     * @throws \Exception
     */
    private function addSocialSettings(array &$result)
    {
        $supportedSocials = config('cms.users.users.supported_socials');

        if (!$supportedSocials) {
            return;
        }

        $socials = new RenderSettings(new Tab('socials', __('cms-users::admin.Socials'), 4, 'fa-key'));

        $index = 0;
        if (in_array('facebook', $supportedSocials)) {
            $result[] = Input::make($socials)
                ->setKey('facebook_id')
                ->setName(__('cms-users::admin.Facebook ID'))
                ->setHelpText(__('cms-users::admin.Application id'))
                ->setRules('nullable|string|max:255')
                ->setSort($index++);
            $result[] = Input::make($socials)
                ->setKey('facebook_secret_key')
                ->setName(__('cms-users::admin.Facebook secret key'))
                ->setHelpText(__('cms-users::admin.Application secret'))
                ->setSmallText(
                    sprintf(
                        '%s <span class="text-primary">%s</span>',
                        __('cms-users::admin.Facebook Redirect URI:'),
                        secure_url(route('auth.socialite.callback', 'facebook', false))
                    )
                )
                ->setRules('nullable|string|max:255')
                ->setSort($index++);
        }

        if (in_array('google', $supportedSocials)) {
            $result[] = Input::make($socials)
                ->setKey('google_id')
                ->setName(__('cms-users::admin.Google ID'))
                ->setRules('nullable|string|max:255')
                ->setSort($index++);
            $result[] = Input::make($socials)
                ->setKey('google_secret_key')
                ->setName(__('cms-users::admin.Google secret key'))
                ->setSmallText(
                    sprintf(
                        '%s <span class="text-primary">%s</span>',
                        __('cms-users::admin.Google Redirect URI:'),
                        secure_url(route('auth.socialite.callback', 'google', false))
                    )
                )
                ->setRules('nullable|string|max:255')
                ->setSort($index++);
        }

        if (in_array('twitter', $supportedSocials)) {
            $result[] = Input::make($socials)
                ->setKey('twitter_id')
                ->setName(__('cms-users::admin.Twitter ID'))
                ->setRules('nullable|string|max:255')
                ->setSort($index++);
            $result[] = Input::make($socials)
                ->setKey('twitter_secret_key')
                ->setName(__('cms-users::admin.Twitter secret key'))
                ->setSmallText(
                    sprintf(
                        '%s <span class="text-primary">%s</span>',
                        __('cms-users::admin.Twitter Redirect URI:'),
                        secure_url(route('auth.socialite.callback', 'twitter', false))
                    )
                )
                ->setRules('nullable|string|max:255')
                ->setSort($index);
        }
    }
}
