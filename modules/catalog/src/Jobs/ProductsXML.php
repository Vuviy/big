<?php

namespace WezomCms\Catalog\Jobs;

use Cocur\Slugify\Slugify;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use WezomCms\Catalog\Http\Controllers\Admin\XmlTestController;
use WezomCms\Catalog\Models\CategoryTest;
use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\Models\ProductTest;

class ProductsXML
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
        $o = collect($file->offers());
        foreach ($o->chunk(500) as $offer){
            foreach ($offer as $product) {
                    ProductTest::updateOrCreate(
                        ['id' => $product['@attributes']['id']],
                        ['available' => $product['available'] ? 1 : 0,
                          'vendor_code' => $product['vendorCode'],
                          'cost' => $product['price'],
                          'category_id' => $product['categoryId'],
                            'ru' => [
                            'product_test_id' => $product['@attributes']['id'],
                            'locale' => 'ru',
                            'name' => $product['name'],
                            'text' => $product['description'],
                            'slug' => $slug->slugify($product['name']),],
                          'videos' => []
                        ]);
                }
        }
    }
}
