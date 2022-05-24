<?php

namespace WezomCms\Catalog\Jobs;

use Cocur\Slugify\Slugify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use WezomCms\Catalog\Http\Controllers\Admin\XmlTestController;
use WezomCms\Catalog\Models\CategoryTest;
use WezomCms\Catalog\Models\Product;

class CategoriesXML implements ShouldQueue
{
    use Dispatchable;
    use SerializesModels;


    private $arr = [];

    public function __construct($arr){
        $this->arr = $arr;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

//        $file  = file_get_contents(asset('data.xml'));

//        $p = Product::all();

//       $file = new XmlTestController();

        $slug = new Slugify();
        foreach ($this->arr as $cat) {
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
