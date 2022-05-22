<?php

namespace WezomCms\Catalog\Jobs;

use Cocur\Slugify\Slugify;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use WezomCms\Catalog\Http\Controllers\Admin\XmlTestController;
use WezomCms\Catalog\Models\CategoryTest;
use WezomCms\Catalog\Models\Product;

class CategoriesXML
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $file = new XmlTestController();

        $slug = new Slugify();
        foreach ($file->categories() as $cat) {
            CategoryTest::updateOrCreate(
                ['id' => $cat['id'], 'parent_id' => $cat['parent_id'] ?? NULL],
                ['ru' => [
                    'category_test_id' => $cat['id'],
                    'locale' => 'ru',
                    'name' => $cat['name'],
                    'slug' => $slug->slugify($cat['name']),]
                ]);
        }
    }
}
