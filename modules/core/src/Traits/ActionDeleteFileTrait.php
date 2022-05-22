<?php

namespace WezomCms\Core\Traits;

use WezomCms\Catalog\Models\Model;
use WezomCms\Core\Traits\Model\FileAttachable;

trait ActionDeleteFileTrait
{
    /**
     * @param $id
     * @param  string  $field
     * @param  string|null  $locale
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function deleteFile($id, $field = 'file', $locale = null)
    {
        /** @var Model|FileAttachable $obj */
        $obj = $this->modelDeleteFile()::findOrFail($id);

        $obj->deleteFile($field, $locale);

        if (app('request')->expectsJson()) {
            return $this->success();
        } else {
            flash(__('cms-core::admin.layout.File successfully deleted'), 'success');

            return redirect()->back();
        }
    }

    /**
     * @return string|Model
     */
    protected function modelDeleteFile(): string
    {
        return $this->model();
    }
}
