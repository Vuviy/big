<?php

namespace WezomCms\Contacts\Http\Controllers\Site;

use WezomCms\Branches\Models\Branch;
use WezomCms\Core\Http\Controllers\SiteController;

class ContactsController extends SiteController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $settings = settings('contacts', []);

        // Breadcrumbs
        $this->addBreadcrumb(array_get($settings, 'site.name'), route('contacts'));

        $this->seo()->fill(array_get($settings, 'site', []), false);

        $branches = Branch::published()->limit(20)->get();

        $map = $branches->map(function ($branch) use ($settings) {
            return [
                'map' => $branch->map,
                'info' => [
                    'name' => $branch->name,
                    'address' => $branch->address,
                    'phones' => $branch->phones,
                    'schedule' => $branch->schedule
                ]
            ];
        });

        // Render
        return view('cms-contacts::site.index', compact('branches', 'map', 'settings'));
    }
}
