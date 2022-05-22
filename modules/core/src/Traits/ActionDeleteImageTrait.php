<?php

namespace WezomCms\Core\Traits;

use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\ImageAttachable;

trait ActionDeleteImageTrait
{
    /**
     * @param $id
     * @param  string  $field
     * @param  string|null  $locale
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function deleteImage($id, $field = 'image', $locale = null)
    {
        /** @var Model|ImageAttachable $obj */
        $obj = $this->modelDeleteImage()::findOrFail($id);

        $obj->deleteImage($field, $locale);

        if (app('request')->expectsJson()) {
            return $this->success();
        } else {
            flash(__('cms-core::admin.layout.Image successfully deleted'), 'success');

            return redirect()->back();
        }
    }

    /**
     * @return string|Model
     */
    protected function modelDeleteImage(): string
    {
        return $this->model();
    }
}
