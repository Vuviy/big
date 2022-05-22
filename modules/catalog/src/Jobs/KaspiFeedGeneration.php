<?php

namespace WezomCms\Catalog\Jobs;

use Exception;
use URL;
use WezomCms\Catalog\Models\Product;
use XMLWriter;

class KaspiFeedGeneration extends AbstractFeedGeneration
{
    const ALLOW_TAGS = '<strong><em><ul><ol><li><br><sub><sup><div><span><dl><dt><dd><b><i><h1><h2><table><tr><td><th>'.
    '<p><fieldset><form><header>';

    /**
     * @var string
     */
    private $filePath;

    /**
     * Create a new job instance.
     *
     * @param  string  $fileName
     */
    public function __construct(string $fileName = 'kaspi-feed.xml')
    {
        $this->filePath = public_path($fileName);
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $this->generateXML($this->prepareData(), $this->filePath);
    }

    /**
     * @return array
     */
    private function prepareData(): array
    {
        $query = Product::published();

        return $query->with(['brand'])
            ->get()
            ->map(function (Product $product) {
                return [
                    'price' => $this->formatFinanceNumber( $product->old_cost ? $product->old_cost : $product->cost),
                    'sale_price' => $product->old_cost ? $this->formatFinanceNumber($product->cost) : '',
                    'id' => $product->vendor_code,
                    'title' => $product->name,
                    'description' => $this->filterHTML($product->name),
                    'link' => $product->getFrontUrl(),
                    'image_link' => $product->getImageUrl('big'),
                    'availability' => $product->available === true ? 'in_stock' : 'out_of_stock',
                    'brand' => optional($product->brand)->name,
                ];
            })
            ->all();
    }

    /**
     * @param  array  $data
     * @param  string  $filename
     */
    private function generateXML(array $data, string $filename): void
    {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->openUri($filename);
        $writer->startDocument('1.0', 'UTF-8');
        $writer->setIndentString("\t");
        $writer->setIndent(true);
        $writer->startElement('kaspi_catalog');
        $writer->writeAttribute('date', date('Y.m.d H:i:s'));
        $writer->writeAttributeNS('xmlns', 'xsi', null, "http://www.w3.org/2001/XMLSchema-instance");
        $writer->writeAttributeNS('xsi', 'schemaLocation', null, "kaspiShopping http://kaspi.kz/kaspishopping.xsd");

        $writer->writeElement('company', 'CompanyName');
        $writer->writeElement('merchantid', 'CompanyID');

        $writer->startElement('offers');

        //$writer->writeElement('title', 'All products feed');
        //$writer->writeElement('link', URL::to('/'));
        //$writer->writeElement('description', 'Feed '.date('Y.m.d H:i:s'));

        foreach ($data as $item) {
            $writer->startElement('offer');
            $writer->writeAttribute('sku', $item['id']);
            foreach (array_keys($item) as $key) {
                if ($item[$key]) {
                    $writer->writeElementNs(null, $key, null, $item[$key]);
                }
            }
            $writer->endElement();
        }

        $writer->endElement();

        $writer->endElement();
        $writer->endDocument();
        $writer->flush();
    }

    /**
     * @param  int|float  $amount
     * @return string
     */
    private function formatFinanceNumber($amount)
    {
        $code = config('cms.core.money.code');

        return number_format($amount, 2, '.', '')." {$code}";
    }

    /**
     * @param  string|null  $html
     * @return string
     */
    private function filterHTML(?string $html): string
    {
        if (!$html) {
            return '';
        }

        $html = strip_tags($html, self::ALLOW_TAGS);
        $html = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $html);
        $html = preg_replace('/\r\n|\r|\n|\t/', ' ', $html);
        $html = preg_replace('/[\s]+/', ' ', $html);
        $html = preg_replace("/\> \</", '><', $html);
        $html = preg_replace("/\<!--[^\[*?\]].*?--\>/", '', $html);

        return $html;
    }
}
