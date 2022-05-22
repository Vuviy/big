<?php

namespace WezomCms\Catalog\Http\Controllers\Admin;







//use PhpOffice\PhpSpreadsheet\IOFactory;
//use PhpOffice\PhpSpreadsheet\Reader\Xml;

use Cocur\Slugify\Slugify;
use Cviebrock\EloquentSluggable\Sluggable;
use WezomCms\Catalog\Models\CategoryTest;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\CategoryTranslationTest;
use WezomCms\Catalog\Models\CategoryTranslation;


use WezomCms\Core\Settings\Fields\Slug;

class XmltestController
{


    public $spreadsheet;
    public $file;

    public function __construct(){

// xml file path
        $path = asset('data.xml');

        $this->file = simplexml_load_file($path);

// Read entire file into string
        $xmlfile = file_get_contents($path);

// Convert xml string into an object
        $new = simplexml_load_string($xmlfile);
//        dd($new->shop->categories->category->attributes());
// Convert into json
        $con = json_encode($new);

// Convert into associative array
        $this->spreadsheet = json_decode($con, true);
    }
    public function categories(){

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

    public function offers(){
        $offers = [];
        foreach($this->spreadsheet->shop->offers->offer as $offer){
            array_push($offers, $offer);
        }
        return $offers;
    }

    public function params($index){
        $params = [];
        foreach($this->offers()[$index]->param as $value){
            array_push($params, $value);
        }
        return $params;
    }




    public function index(){

//        $spreadsheet = $this->spreadsheet;
//$size = filesize('data.xml');
//
//$mb = $size/1000000 . 'Mb';
//dd($mb);

//        $filename = 'https://al-style.kz/upload/catalog_export/al_style_catalog.php';
//        $content = file_get_contents('https://al-style.kz/upload/catalog_export/al_style_catalog.php');
//
//        $fp = fopen('data.xml', 'w');
//            fwrite($fp, $content);
//        fclose($fp);
//
//            if($fp){
//                return 'yyyy';
//            }


//        $inputFileName = asset('prod.xls');



//        $inputFileName = __DIR__ . '\data.xml';

//        dd($inputFileName);

        /** Load $inputFileName to a Spreadsheet Object  **/
//        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

//        dd($inputFileName);

        /** Load $inputFileName to a Spreadsheet object **/
//        $spreadsheet = IOFactory::load($inputFileName);

//        $rrr = Xml::
//        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($inputFileName);
//        $reader->setReadDataOnly(true);
//        $reader->load($inputFileName);

//        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xml");
//        $spreadsheet = $reader->load(asset('prod-cut.xml'));


//        $reader = Xml::class;

//        $spreadsheet = $reader->trySimpleXMLLoadString('prod-cut.xml');
//        $spreadsheet = $reader->listWorksheetNames('prod-cut.xml');
//
//        $reader = new Xml();
//        $spreadsheet = $reader->load($inputFileName);

//        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xml();
//        $spreadsheet = $reader->load($inputFileName);



//        (asset('prod-cut.xml'));

//        $xml = simplexml_load_file(asset('prod-cut.xml'));

//        for($i = 0; $i < 10 ; $i++){
//            CategoryTest::create([
//                'id' => $this->categories()[$i]['@attributes']['id'],
////                'parent_id' => $this->categories()[$i]['@attributes']['parentId'] ?? NULL,
//            ]);
//        }


//        CategoryTest::create([
//                'id' => $this->categories()[6]['@attributes']['id'],
//                'published' => 0,
//
//////                'parent_id' => $this->categories()[$i]['@attributes']['parentId'] ?? NULL,
//            ]);

//        Category::upsert($this->categories(), ['id'], ['id', 'parent_id', 'image']);
//        foreach ($this->categories() as $cat){
//            Category::updateOrCreate(
//                ['id' => $cat['id']],
//                ['parent_id' => $cat['parent_id'] ?? NULL]
//            );
//        }
//        $slug = Slugify::create();
//        foreach ($this->categories() as $cat){
//            CategoryTranslationTest::updateOrCreate(
//                ['name' => $cat['name']],
//                ['category_tests_id' => $cat['id'],
//                 'locale' => 'ru',
//                 'slug' => $slug->slugify($cat['name'])
//                    ]
//            );
//        }


//        CategoryTranslation::create([
//            'name' => 'Слава Україні',
//            'category_id' => 3419,
//            'locale' => 'ru',
//            'slug' => $slug->slugify('Слава Україні')
//        ]);





        $var ='dd';

        return view('cms-catalog::admin.xmltest', compact('var'));
    }


}
