<?php

namespace WezomCms\Catalog\Http\Controllers\Admin;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xml;
use WezomCms\Catalog\Http\Requests\Admin\ImportRequest;
use WezomCms\Catalog\Http\Requests\Admin\ProductRequest;
use WezomCms\Catalog\Jobs\CategoriesXML;
use WezomCms\Catalog\Jobs\ParceXMLFile;
use WezomCms\Catalog\Jobs\ProductsXML;
use WezomCms\Catalog\Models\Brand;
use WezomCms\Catalog\Models\BrandTranslation;
use WezomCms\Catalog\Models\CategoryTest;
use WezomCms\Catalog\Models\CategoryTestTranslation;
use WezomCms\Catalog\Models\CategoryTranslation;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\Import;
use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\Models\ProductSpecification;
use WezomCms\Catalog\Models\ProductTest;
use WezomCms\Catalog\Models\ProductImage;
use WezomCms\Catalog\Models\Specifications\Specification;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Image\ImageService;
use WezomCms\Core\Traits\AjaxResponseStatusTrait;

class XmlController extends AbstractCRUDController
{

    use AjaxResponseStatusTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Import::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-catalog::admin.import';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.imports';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = ImportRequest::class;

    public $file;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-catalog::admin.Import');
    }

    public function indexViewData($result, array $viewData): array
    {
        //$obj = Import::first();
        //simplexml_load_file(public_path('storage/xml/'). $obj->file);
        /// ParceXMLFile::dispatch($obj);
        return [];
    }

    public function store()
    {
//        $formRequest = app($this->createRequest());
//
//        $obj = new $this->model;
//        $name = date('Y-m-d') . $formRequest->file('file')->getClientOriginalName();
//        Storage::putFileAs('public/xml', $formRequest->file('file'), $name);
//        $formRequest->file('file')->store('public/xml');
//        $obj->fill(['file' => $name]);
//        $obj->save();

//        $data = Storage::get('public/xml/'. $obj->file);

        $data = asset('data.xml');
        $this->file = simplexml_load_file($data);





//        dd([3684]));

        $p = $this->arrayForSpecification($this->offers());
        dd($p);

//        ParceXMLFile::dispatch($obj);


//        flash(__('cms-core::admin.layout.Data successfully created'))->success();

//        return redirect($this->listRoute('admin.imports'));
    }


    public function _construct()
    {
        $fileName = asset('data.xml');
        $this->file = simplexml_load_file($fileName);
    }

    public function arrayForSpecification($offers){
        $params = [];
        foreach ($offers as $item){

            foreach ($item['param'] as $key => $value){
                array_push($params, str_slug($key));
            }
//            $unique = array_unique($params);

//            foreach ($unique as $key => $value){
//                $arr = [];
//                $arr['slug'] = str_slug($key);
//                $arr['color'] = null;
//                $arr['ru'] = ['name' => $key];
//                array_push($params, $arr);
//            }
        }
        return array_unique($params);
    }

    public function arrayForSpecValues($offers){

//        $spec = $this->arrayForSpecification($offers);
//        $spec = [];
//        for
//
//
//        $unique = array_unique();
//        return $unique;

//        $specification = [];
//        foreach ($offers as $item){
//            foreach ($item['param'] as $key => $value){
//                $arr = [];
//                $arr['slug'] = str_slug($key);
//                $arr['color'] = null;
//                $arr['ru'] = ['name' => $key];
//                array_push($params, $arr);
//            }
//        }
//        return $params;

    }


    public function params($offer)
    {
        $param = [];
        foreach ($offer->param as $par) {
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
        $offers = [];
        foreach ($this->file->shop->offers->offer as $off) {
            $arr = json_decode(json_encode($off), true);

            $cat = Category::where('import_id', $arr['categoryId'])->first();
            $catId = $cat->id;

            $arr['param'] = array_combine($this->params($off), $arr['param']);

            if (isset($arr['param']['Аналогичные товары'])) {
                unset($arr['param']['Аналогичные товары']);
            }

            $body = [
                'import_id' => $arr['@attributes']['id'],
                'category_id' => $catId,
                'cost' => $arr['price'],
                'vendor_code' => $arr['vendorCode'],
                'available' => $arr['available'] ? 1 : 0,
                'quantity' => $arr['quantity'],
                'param' => $arr['param'],
                'ru' => [
                    'locale' => 'ru',
                    'name' => $arr['name'],
                    'text' => (is_array($arr['description'])) ? null : $arr['description'],
                    'slug' => str_slug($arr['name']),],
                'videos' => []
            ];

            if(isset($arr['vendor'])){
                $body['vendor'] = $arr['vendor'];
            }
            if(isset($arr['picture'])){
                $body['picture'] = $arr['picture'];
            }
            array_push($offers, $body);
        }
        return $offers;
    }


    public function categories()
    {
        $array = [];
        $categories = [];

        foreach ($this->file->shop->categories->category as $cat) {
            array_push($array, json_decode(json_encode($cat), true));
        }
        foreach ($array as $catagory) {
            $cat = [];
            $cat['name'] = $catagory[0];
            $cat['id'] = $catagory['@attributes']['id'];
            if (isset($catagory['@attributes']['parentId'])) {
                $cat['parent_id'] = $catagory['@attributes']['parentId'];
            }
            array_push($categories, $cat);
        }
        return $categories;
    }


    public function upload(Request $request)
    {
//        $fileName = asset('data.xml');
        dd($request);
//        $this->file = simplexml_load_file($request->file);
    }

    public function specification($product)
    {

        $specs = [];
        foreach ($product['param'] as $key => $value) {
            $array = [
                'published' => 1,
                'slug' => str_slug($key),
                'ru' => ['name' => $key]
            ];
            array_push($pecs, $array);
        }
        return $specs;
    }
}
