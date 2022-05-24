<?php

namespace WezomCms\Catalog\Http\Controllers\Admin;

use Cocur\Slugify\Slugify;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Reader\Xml;
use WezomCms\Catalog\Jobs\CategoriesXML;
use WezomCms\Catalog\Jobs\ProductsXML;
use WezomCms\Catalog\Models\CategoryTest;
use WezomCms\Catalog\Models\CategoryTestTranslation;
use WezomCms\Catalog\Models\CategoryTranslation;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\Models\ProductTest;
use WezomCms\Catalog\Models\ProductImage;
use WezomCms\Catalog\Models\Specifications\Specification;
use WezomCms\Core\Image\ImageService;
use SimpleXMLElement;


class XmlTestController
{
    public $file;

    public function __construct()
    {

        $fileName = asset('data.xml');
        $this->file = simplexml_load_file($fileName);
    }


    public function params($offer){

        $param = [];
        foreach ($offer->param as $par){
            $arr = json_decode(json_encode($par->attributes()->name), true);
            array_push($param, $arr);
        }
        $colect = collect($param);
        $col = $colect->collapse();
        $params = $col->all();

        return $params;
    }



    public function offers()
    {
        $array = [];
        $offers = [];
        foreach ($this->file->shop->offers->offer as $off) {
            $body = json_decode(json_encode($off), true);
            if(is_array($body['description'])){
                $body['description'] = NULL;
            }
            $body['param'] = array_combine($this->params($off), $body['param']) ;
            array_push($offers, $body);
        }

//        foreach ($array as $product) {
//            $slug = new Slugify();
//            $arr = [
//                'id' => $product['@attributes']['id'],
//                'available' => $product['available'] ? 1 : 0,
//                'vendor_code' => $product['vendorCode'],
//                'cost' => $product['price'],
//                'category_test_id' => $product['categoryId'],
//                'ru' => [
//                    'product_test_id' => $product['@attributes']['id'],
//                    'locale' => 'ru',
//                    'name' => $product['name'],
//                    'text' => $product['description'],
//                    'slug' => $slug->slugify($product['name']),],
//                'videos' => []
//            ];
//            array_push($offers, $arr);
//        }

        return $offers;
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

    public function specification($product){

        $specs = [];
        $slug = new Slugify();
        foreach ($product['param'] as $key => $value){
            $array = [
            'published' => 1,
            'slug' => $slug->slugify($key),
            'color' => null,
            'ru' =>['name' => $key]
            ];
            array_push($pecs, $array);
        }

        return $specs;
    }

    public function index()
    {

        ProductTest::updateOrCreate(
            ['id' => 666666666],
            ['available' => 1 ,
             'vendor_code' => 6666666,
             'cost' => 66666666,
             'category_test_id' => 3416,
             'SPEC_VALUES' => [
                 12 => [1],
                 4 => [1]
             ],
             'ru' => [
                    'product_test_id' => 666666666,
                    'locale' => 'ru',
                    'name' => 'QQQQQQQQQ',
                    'text' => 'QQQQQQQQQQQQ',
                    'slug' => 'QQQQQQQQ',],
                'videos' => []
            ]);

//          Specification::upsert('arr', ['slug'], [
//                  'slug',
//                  'ru' => ['name']
//                  ]
//        );

//        $specification = Specification::findOrFail(14);
//
//
//        $data = [
//            'published' => 1,
//            'slug' => 'QQQQQQQQ',
//            'color' => null,
//            'ru' =>['name' => 'QQQQQQQQ']
//        ];
//
//        $specification->specValues()->create($data);

//        CategoriesXML::dispatch($this->categories());

//        $var = [];
//        $o = collect($this->offers());

        $arr100 = [];
//        foreach (array_chunk($this->offers(), 100) as $offer) {
//            array_push($arr100, $offer);
//            ProductsXML::dispatch($offer);
//        }

//        $ar10 = [];
//        foreach (array_chunk($arr100[74], 10) as $of){
//            array_push($ar10, $of);
//            ProductsXML::dispatch($of);
//        }

//        foreach (array_chunk($ar10[2], 2) as $of){
//            array_push($ar10, $of);
//        }
//        $var = $this->offers();
            $var = 'dd';

        return view('cms-catalog::admin.xmltest', compact('var'));
    }
}


//=========================
//=======================
//"_method" => "PUT"
//      "_token" => "ejzJwafy1DXIAAuIHJY7ydWR0sZdTgvlvchh21y9"
//      "ru" => array:7 [▶]
//      "primarySpecValues" => array:1 [▼
//        0 => "8"
//      ]
//      "SPEC_VALUES" => array:2 [▼
//        12 => array:1 [▶]
//        3 => array:1 [▶]
//      ]
//      "group_key" => null
//      "published" => "1"
//      "available" => "1"
//      "vendor_code" => "127"
//      "category_id" => "9"
//      "model_id" => "2"
//      "novelty" => "1"
//      "popular" => "1"
//      "sale" => "0"
//      "cost" => "128599"
//      "old_cost" => "0"
//      "discount_percentage" => null
//      "expires_at" => null
//      "PRODUCT_ACCESSORIES" => array:2 [▶]
//      "videos" => array:1 [▶]
//      "proengsoft_jsvalidation" => null
//      "form-action" => "save"
//    ]

//=======================
//=====================

//"ru" => array:1 [▼
//    "name" => "eerere"
//  ]
//  "published" => "1"
//  "multiple" => "0"
//  "slug" => "eerere"
//]

//spec
//=============
//=============


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


//        foreach ($array as $product) {
//            $slug = new Slugify();
//            $arr = [
//                'id' => $product['@attributes']['id'],
//                'available' => $product['available'] ? 1 : 0,
//                'vendor_code' => $product['vendorCode'],
//                'cost' => $product['price'],
//                'category_test_id' => $product['categoryId'],
//                'ru' => [
//                    'product_test_id' => $product['@attributes']['id'],
//                    'locale' => 'ru',
//                    'name' => $product['name'],
//                    'text' => $product['description'],
//                    'slug' => $slug->slugify($product['name']),],
//                'videos' => []
//            ];
//            array_push($offers, $arr);
//        }

//

//            $param = [];
//            foreach ($off->param as $par){
////                $arr = [json_decode(json_encode($par), true) => json_decode(json_encode($par), true)];
//                $arr = [$par->attributes()->name => 'eee'];
//                array_push($param, $arr);
//            }

//            $parr = [];

//            for($i = 0; $i < count($body['param']); $i++){
//                $data[$body['param'][$i]] = $param[$i][0];
//                array_push($parr, $data);
////                $parr[$body['param'][$i] = $param[$i][0]];
//            }
//            $body['param'] = $param;





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



//        $fileName = asset('data.xml');

//        $var = new Xml();
//        $var->canRead($fileName);

//        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xml");
//        $var = $reader->load($fileName);

//        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xml();
//        $var = $reader->load($fileName);

// Read entire file into string
//        $xmlfile = file_get_contents($fileName);

// Convert xml string into an object

// Convert into json
//        $con = json_encode($xmlfile);
//
//// Convert into associative array
//        $var = json_decode($con, true);
//        $var = $this->file->shop->offers->offer;


//        CategoriesXML::dispatch($this->categories());
//        $var = $this->offers();


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

//        $arr =  [
//            'id'=> 3422,
//            'published' => 1,
//            'parent_id' => null,
//            'show_on_main' => 0,
//            'show_on_menu' => 0,
//            'ru' => [
//                'name' => 'aaaaa',
//                'slug' => 'aaaaa',
//                'text' => null,
//                'title' => null,
//                'h1' => null,
//                'keywords' => null,
//                'description' => null,
//            ],
//        ];


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
