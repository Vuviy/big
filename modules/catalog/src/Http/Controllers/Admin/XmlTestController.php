<?php

namespace WezomCms\Catalog\Http\Controllers\Admin;

use Cocur\Slugify\Slugify;
use Illuminate\Support\Facades\Artisan;
use WezomCms\Catalog\Jobs\CategoriesXML;
use WezomCms\Catalog\Jobs\ProductsXML;
use WezomCms\Catalog\Models\CategoryTest;
use WezomCms\Catalog\Models\CategoryTestTranslation;
use WezomCms\Catalog\Models\CategoryTranslation;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\Models\ProductTest;
use WezomCms\Catalog\Models\ProductImage;
use WezomCms\Core\Image\ImageService;


class XmlTestController
{
    public $file;

    public function __construct()
    {
        $fileName = asset('data.xml');
        $this->file = simplexml_load_file($fileName);
        //        $this->file = simplexml_load_string($fileName);

        //        $array = json_decode(json_encode($this->file), TRUE);


//        $path = asset('data.xml');
//
//// Read entire file into string
//        $xmlfile = file_get_contents($path);
//
//// Convert xml string into an object
//        $new = simplexml_load_string($xmlfile);
//
//// Convert into json
//        $con = json_encode($new);
//
//// Convert into associative array
//        $newArr = json_decode($con, true);
//
//        $var = $newArr;
    }

    public function offers(){
        $array = [];
//        $offers = [];
        foreach ($this->file->shop->offers->offer as $off) {
//            $param = [];
//            foreach ($off->param as $par){
////                $arr = [json_decode(json_encode($par), true) => json_decode(json_encode($par), true)];
//                $arr = [$par->attributes()->name => 'eee'];
//                array_push($param, $arr);
//            }
            $body = json_decode(json_encode($off), true);
            $parr = [];

//            for($i = 0; $i < count($body['param']); $i++){
//                $data[$body['param'][$i]] = $param[$i][0];
//                array_push($parr, $data);
////                $parr[$body['param'][$i] = $param[$i][0]];
//            }
//            $body['param'] = $param;
            array_push($array, $body);



        }
//        foreach ($array as $offer){
//            $of = [];
//            $of['name'] = $offer[0];
//            $of['id'] = $offer['@attributes']['id'];
//            if(isset($offer['@attributes']['parentId'])){
//                $of['parent_id'] = $offer['@attributes']['parentId'];
//            }
//            array_push($offers, $of);
//        }
//
        return $array;
    }







    public function categories()
    {
        $array = [];
        $categories = [];

        foreach ($this->file->shop->categories->category as $cat) {
            array_push($array, json_decode(json_encode($cat), true));
        }
        foreach ($array as $catagory){
            $cat = [];
            $cat['name'] = $catagory[0];
            $cat['id'] = $catagory['@attributes']['id'];
            if(isset($catagory['@attributes']['parentId'])){
                $cat['parent_id'] = $catagory['@attributes']['parentId'];
            }
            array_push($categories, $cat);
        }
        return $categories;
    }

    public function index()
    {

//        CategoriesXML::dispatch();
        ProductsXML::dispatch();
//        $var = $this->categories();


        //        for($i = 0;count($this->categories()) < $i; $i++){
        //            CategoryTest::create([
        //                'id' => $this->categories()[0]['id'],
        //                'parent_id' => 3
        //            ]);
        //
        //        }
        //        $var = CategoryTest::create([
        //            'parent_id' => 3
        //        ]);

        $arr =  [
            'id'=> 3422,
            'published' => 1,
            'parent_id' => null,
            'show_on_main' => 0,
            'show_on_menu' => 0,
            'ru' => [
                'name' => 'aaaaa',
                'slug' => 'aaaaa',
                'text' => null,
                'title' => null,
                'h1' => null,
                'keywords' => null,
                'description' => null,
            ],
        ];

//        $model = new Category();
//
//        $model->fill($arr);
//
//        $model->save();


//        $slug = new Slugify();
//        foreach ($this->categories() as $cat) {
//            CategoryTest::updateOrCreate(
//                ['id' => $cat['id'], 'parent_id' => $cat['parent_id'] ?? NULL],
//                ['ru' => [
//                    'category_test_id' => $cat['id'],
//                    'locale' => 'ru',
//                    'name' => $cat['name'],
//                    'slug' => $slug->slugify($cat['name']),]
//                ]);
//        }


//            Category::create(
//                [
//                'id' => 999,
//                'parent_id' => NULL,
//                        'ru' => [
//                            'category_id' => 999,
//                            'locale' => 'ru',
//                            'name' => 'ttt',
//                            'slug' => 'ttt',]
//                ]
//            );
//        }

//        CategoryTranslation::create([
//            'category_id' => 4,
//            'locale' => 'ru',
//            'name' => 'ttt',
//            'slug' => 'ttt',
//        ]);


//        produvt =======

//        "published" => "1"
//  "available" => "1"
//  "group_key" => null
//  "vendor_code" => "342344"
//  "novelty" => "0"
//  "popular" => "0"
//  "sale" => "0"
//  "cost" => "4333"
//  "old_cost" => 0
//  "category_id" => "3"
//  "expires_at" => null
//  "discount_percentage" => null
//  "model_id" => null
//  "ru" => array:7 [▼
//    "name" => "товар 1"
//    "slug" => "tovar-1"
//    "text" => "<p>діскриптіон</p>"
//    "title" => null
//    "h1" => null
//    "keywords" => null
//    "description" => null
//  ]
//  "videos" => []
//]


//        img=============
//        $img = new ImageService();
//        $model = new ProductImage();
//        $model->product_id = 4;
//        $sourse = 'https://img.al-style.kz/19510_1.jpg';
//        $img->uploadImage($model, $sourse);
//
//
//        $slug = new Slugify();
//        $o = collect($this->offers());
//        foreach ($o->chunk(500) as $offer){
//            foreach ($offer as $product) {
//                    ProductTest::updateOrCreate(
//                        ['id' => $product['@attributes']['id']],
//                        ['available' => $product['available'] ? 1 : 0,
//                          'vendor_code' => $product['vendorCode'],
//                          'cost' => $product['price'],
//                          'category_id' => $product['categoryId'],
//                            'ru' => [
//                            'product_test_id' => $product['@attributes']['id'],
//                            'locale' => 'ru',
//                            'name' => $product['name'],
//                            'text' => $product['description'],
//                            'slug' => $slug->slugify($product['name']),],
//                          'videos' => []
//                        ]);
//                }
//        }


//        Artisan::call('product-from-XML:upload');
        $var = 'ddd';



        return view('cms-catalog::admin.xmltest', compact('var'));
    }
}
