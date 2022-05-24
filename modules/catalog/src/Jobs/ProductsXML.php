<?php

namespace WezomCms\Catalog\Jobs;

use Cocur\Slugify\Slugify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use WezomCms\Catalog\Http\Controllers\Admin\XmlTestController;
use WezomCms\Catalog\Models\CategoryTest;
use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\Models\ProductTest;

class ProductsXML implements ShouldQueue
{
    use Dispatchable;
    use SerializesModels;


    private $arr;

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

//        if(is_array($this->arr)){
//
//                Log::info('це масів');
//            }
//        } else{
//            Log::info('це НЕ масів');
//        }

        $slug = new Slugify();

        foreach ($this->arr as $product) {
                ProductTest::updateOrCreate(
                    ['id' => $product['@attributes']['id']],
                    ['available' => $product['available'] ? 1 : 0,
                        'vendor_code' => $product['vendorCode'],
                        'cost' => $product['price'],
                        'category_test_id' => $product['categoryId'],
                        'ru' => [
                            'product_test_id' => $product['@attributes']['id'],
                            'locale' => 'ru',
                            'name' => $product['name'],
                            'text' => $product['description'],
                            'slug' => $slug->slugify($product['name']),],
                        'videos' => []
                    ]);
            }

//            ProductTest::upsert($this->arr, ['id'], [
//            'available',
//            'vendor_code',
//            'cost',
//            'category_test_id',
//            'ru' => [
//                'product_test_id',
//                'name',
//                'text',
//                'slug',]
//            ]
//        );



        }

//

}


//    2-3
//    4-5
//    6-6.5
