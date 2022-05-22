<?php


namespace WezomCms\Core\Files;


use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\FileAttachable;

class VideoService extends FileService
{
    public const VIDEO = 'video';

    /**
     * @param  Model|FileAttachable  $model
     * @param  string  $field
     * @return array|null
     */
    public function getRecommendUploadVideoResolution($model, string $field = self::VIDEO): ?array
    {
        $sizes = array_get($this->extractSetting($model, $field), 'sizes', []);

        if (!$sizes) {
            return null;
        }

        $width = array_column($sizes, 'width');
        $height = array_column($sizes, 'height');

        if (!$width || !$height) {
            return null;
        }

        return [
            'width' => max($width),
            'height' => max($height),
        ];
    }

    /**
     * @param  Model|FileAttachable  $model
     * @param  string  $field
     * @return array|null
     */
    public function getRecommendUploadVideoMaxFileSize($model, string $field = self::VIDEO): ?string
    {
        return array_get($this->extractSetting($model, $field), 'max_file_size', '30');
    }
}
