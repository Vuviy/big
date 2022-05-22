<?php

namespace WezomCms\Faq\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\SchemaOrg\Schema;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Core\Traits\MicroDataTrait;
use WezomCms\Faq\Models\FaqGroup;
use WezomCms\Faq\Models\FaqQuestion;

class FaqController extends SiteController
{
    use MicroDataTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        // Selection
        $result = FaqGroup::published()
            ->with([
                'faqQuestions' => function ($query) {
                    $query->published()->sorting();
                }
            ])
            ->whereHas('faqQuestions', function ($query) {
                $query->published();
            })
            ->sorting()
            ->get();

        $this->setSeo($result->pluck('faqQuestions')->flatten());

        // Render
        return view('cms-faq::site.index', compact('result'));
    }

    public function loadMore(int $id, Request $request)
    {
        if ($request->expectsJson()) {
            $questions = FaqQuestion::where('faq_group_id', $id)->published()->sorting()->paginate(settings('faq.site.limit', 10));

            return JsResponse::make(
                [
                    'html' => view('cms-faq::site.partials.faq-list', compact('questions'))->render(),
                    'more' => $questions->hasMorePages(),
                    'newPageUrl' => $questions->url($questions->currentPage() + 1),
                ]
            );
        }

        abort(404);
    }

    /**
     * @param Collection|\Illuminate\Database\Eloquent\Collection|FaqQuestion[] $questions
     */
    protected function setSeo($questions)
    {
        $settings = settings('faq.site', []);

        // Breadcrumbs
        $this->addBreadcrumb(array_get($settings, 'name'), route('faq'));

        $this->seo()->fill($settings, false);

        // Render faq micro markup
        $questions = $questions->filter(function (FaqQuestion $question) {
            return $question->question && strip_tags($question->answer);
        });

        if ($questions->isNotEmpty()) {
            $things = $questions->map(function (FaqQuestion $question) {
                return Schema::question()
                    ->name($question->question)
                    ->acceptedAnswer(Schema::answer()->text(strip_tags($question->answer)));
            })
                ->values()
                ->all();

            $this->renderMicroData(Schema::fAQPage()->mainEntity($things));
        }
    }
}
