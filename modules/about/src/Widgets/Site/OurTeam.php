<?php

namespace WezomCms\About\Widgets\Site;

use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;
use WezomCms\OurTeam\Models\Employee;
use WezomCms\OurTeam\Models\EmployeeTranslation;

class OurTeam extends AbstractWidget
{
    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [Employee::class, EmployeeTranslation::class, Translation::class];

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $result = Employee::published()
            ->sorting()
            ->limit(6)
            ->get();

        if ($result->isEmpty()) {
            return null;
        }

        return [
            'result' => $result
        ];
    }
}
