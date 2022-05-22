<?php

namespace WezomCms\Newsletter\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use JsValidator;
use Notification;
use WezomCms\Core\Contracts\Assets\AssetManagerInterface;
use WezomCms\Core\Contracts\ButtonsContainerInterface;
use WezomCms\Core\Contracts\Filter\RestoreFilterInterface;
use WezomCms\Core\Foundation\Buttons\ButtonsMaker;
use WezomCms\Core\Http\Controllers\AdminController;
use WezomCms\Core\Traits\ActionShowTrait;
use WezomCms\Newsletter\Http\Requests\Admin\SendLetterRequest;
use WezomCms\Newsletter\ModelFilters\NewsletterHistoryFilter;
use WezomCms\Newsletter\Models\NewsletterHistory;
use WezomCms\Newsletter\Models\Subscriber;
use WezomCms\Newsletter\Notifications\Newsletter;

class NewsletterController extends AdminController
{
    use ActionShowTrait;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-newsletter::admin.newsletter';

    /**
     * @return null|string
     */
    protected function abilityPrefix(): ?string
    {
        return 'newsletter';
    }

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-newsletter::admin.Mailing list');
    }

    /**
     * Model name.
     *
     * @return string|Model
     */
    protected function model(): string
    {
        return NewsletterHistory::class;
    }

    /**
     * @param  string  $actionName
     * @return string
     */
    protected function makeRouteName(string $actionName): string
    {
        return 'admin.newsletter.' . $actionName;
    }

    /**
     * Render form for sending new letter.
     *
     * @param  ButtonsContainerInterface  $buttonsContainer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function form(ButtonsContainerInterface $buttonsContainer)
    {
        $this->authorizeForAction('send');

        $send = ButtonsMaker::save()
            ->setName(__('cms-newsletter::admin.Send a letter'))
            ->setIcon('fa-send');

        $buttonsContainer->add($send);

        $this->addBreadcrumb(__('cms-newsletter::admin.Send a letter'));
        $this->pageName->setPageName(__('cms-newsletter::admin.Send a letter'));

        $this->assets->addInlineScript(JsValidator::formRequest(new SendLetterRequest(), '#form'))
            ->group(AssetManagerInterface::GROUP_ADMIN);

        return view('cms-newsletter::admin.newsletter.form', ['locales' => app('locales')]);
    }

    /**
     * Send letter
     *
     * @param  SendLetterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function send(SendLetterRequest $request)
    {
        $this->authorizeForAction('send');

        $locale = $request->get('locale');

        /** @var Collection $subscribers */
        $subscribers = Subscriber::active()
            ->where('locale', $locale)
            ->get();

        if ($subscribers->isEmpty()) {
            flash(__('cms-newsletter::admin.No subscribers for language'))
                ->error();

            return redirect()->back()->withInput($request->all());
        }

        $subject = $request->get('subject');
        $text = $request->get('text');

        // Notify
        Notification::locale($locale)
            ->send($subscribers, new Newsletter($subject, $text));

        // Save history
        NewsletterHistory::create([
            'subject' => $subject,
            'text' => $text,
            'locale' => $locale,
            'count_emails' => $subscribers->count(),
        ]);

        flash(__('cms-newsletter::admin.Newsletter successfully sent'))->success();

        return redirect()->route('admin.newsletter.form');
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function list(Request $request)
    {
        $this->authorizeForAction('view', $this->model());

        if (($response = resolve(RestoreFilterInterface::class)->handle($request)) !== null) {
            return $response;
        }

        $this->addBreadcrumb($this->title());
        $this->pageName->setPageName($this->title());

        $data = [];
        $data['result'] = NewsletterHistory::filter($request->all())
            ->paginate($this->getLimit($request))
            ->appends($request->query());

        $data['filterFields'] = new NewsletterHistoryFilter($this->model()::query());
        $data['perPageList'] = $this->perPageList();

        return view('cms-newsletter::admin.newsletter.index', $data);
    }
}
