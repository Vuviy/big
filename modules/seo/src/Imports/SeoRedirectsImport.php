<?php

namespace WezomCms\Seo\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use WezomCms\Seo\Enums\RedirectHttpStatus;
use WezomCms\Seo\Models\SeoRedirect;

class SeoRedirectsImport implements ToModel, SkipsOnError
{
    use Importable;
    use SkipsErrors;

    /**
     * @param  array  $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $from = array_get($row, 0);
        $to = array_get($row, 1);

        // Remove domain
        $fromParts = parse_url($from);
        $from = $fromParts['path'] . (isset($fromParts['query']) ? "?{$fromParts['query']}" : '');

        $from = rtrim($from, '/');
        $to = rtrim($to, '/');

        if (!$from) {
            return null;
        }

        $status = (int) array_get($row, 2);
        if (!RedirectHttpStatus::hasValue($status)) {
            $status = 301;
        }

        $redirect = SeoRedirect::firstOrCreate(
            ['link_from' => $from],
            [
                'link_to' => $to,
                'http_status' => (string) $status,
            ]
        );

        return $redirect->fill([
            'link_to' => $to,
            'http_status' => (string) $status,
            'published' => true,
        ]);
    }
}
