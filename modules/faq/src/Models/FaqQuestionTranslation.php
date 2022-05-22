<?php

namespace WezomCms\Faq\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \WezomCms\Faq\Models\FaqQuestionTranslation
 *
 * @property int $id
 * @property int $faq_question_id
 * @property string $question
 * @property string|null $answer
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestionTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestionTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestionTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestionTranslation whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestionTranslation whereFaqQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestionTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestionTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestionTranslation whereQuestion($value)
 * @mixin \Eloquent
 */
class FaqQuestionTranslation extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['question', 'answer'];
}
