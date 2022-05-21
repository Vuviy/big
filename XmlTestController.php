<?php

namespace WezomCms\Catalog\Http\Controllers\Admin;

use DOMDocument;
use SimpleXMLElement;
use WezomCms\Catalog\Models\CategoryTest;

class XmlTestController
{
    public $file;

    public function __construct()
    {
        $fileName = asset('data.xml');
        $this->file = simplexml_load_file($fileName);
        //        $this->file = simplexml_load_string($fileName);

        //        $array = json_decode(json_encode($this->file), TRUE);

    }




    function XMLtoArray($xml)
    {
        $previous_value = libxml_use_internal_errors(true);
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->loadXml($xml);
        libxml_use_internal_errors($previous_value);
        if (libxml_get_errors()) {
            return [];
        }
        return $this->DOMtoArray($dom);
    }

    function DOMtoArray($root)
    {
        $result = array();

        if ($root->hasAttributes()) {
            $attrs = $root->attributes;
            foreach ($attrs as $attr) {
                $result['@attributes'][$attr->name] = $attr->value;
            }
        }

        if ($root->hasChildNodes()) {
            $children = $root->childNodes;
            if ($children->length == 1) {
                $child = $children->item(0);
                if (in_array($child->nodeType, [XML_TEXT_NODE, XML_CDATA_SECTION_NODE])) {
                    $result['_value'] = $child->nodeValue;
                    return count($result) == 1
                        ? $result['_value']
                        : $result;
                }
            }
            $groups = array();
            foreach ($children as $child) {
                if (!isset($result[$child->nodeName])) {
                    $result[$child->nodeName] = $this->DOMtoArray($child);
                } else {
                    if (!isset($groups[$child->nodeName])) {
                        $result[$child->nodeName] = array($result[$child->nodeName]);
                        $groups[$child->nodeName] = 1;
                    }
                    $result[$child->nodeName][] = $this->DOMtoArray($child);
                }
            }
        }
        return $result;
    }



    public function categories()
    {

        //        $categories = $this->file->shop->categories->category;
        //
        //        return $categories;


        $categories = [];

        foreach ($this->file->shop->categories->category as $cat) {
            $arr = [];
            $arr['name'] = $cat;
            $arr['id'] = $cat->attributes()->id;
            $arr['parentId'] = $cat->attributes()->parentId;

            //            foreach ($cat->attributes() as $attr){
            //                $arr[$attr->attributes()] = $attr;
            //            }
            array_push($categories, $arr);
        }
        return $categories;
    }

    public function index()
    {

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

        // xml file path
        $path = asset('data.xml');

// Read entire file into string
        $xmlfile = file_get_contents($path);

// Convert xml string into an object
        $new = simplexml_load_string($xmlfile);

// Convert into json
        $con = json_encode($new);

// Convert into associative array
        $newArr = json_decode($con, true);

        $var = $newArr;


//        $var = $this->categories();

        return view('cms-catalog::admin.xmltest', compact('var'));
    }
}
