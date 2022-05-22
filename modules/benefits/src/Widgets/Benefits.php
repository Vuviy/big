<?php

namespace WezomCms\Benefits\Widgets;

use WezomCms\Benefits\Enums\BenefitsTypes;
use WezomCms\Benefits\Models\Benefits as BenefitsModel;
use WezomCms\Benefits\Models\BenefitsTranslation;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;

class Benefits extends AbstractWidget
{
    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [BenefitsModel::class, BenefitsTranslation::class, Translation::class];

	/**
	 * @return array|null
	 */
    public function execute(): ?array
	{
        $type = array_get($this->data, 'type', BenefitsTypes::COMMON);
        $limit = array_get($this->data, 'limit', 4);

        $result = BenefitsModel::where('type', $type)
            ->published()
            ->sorting()
            ->limit($limit)
            ->get();

        if ($result->isEmpty()) {
            return null;
        }

		return [
			'result' => $result
		];
	}
}
