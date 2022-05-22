<?php

namespace WezomCms\Seo\Http\Controllers\Admin;

use WezomCms\Core\Contracts\ButtonsContainerInterface;
use WezomCms\Core\Foundation\Buttons\ButtonsMaker;
use WezomCms\Core\Http\Controllers\AdminController;
use WezomCms\Seo\Http\Requests\Admin\ImportRedirectsRequest;
use WezomCms\Seo\Imports\SeoRedirectsImport;

class ImportRedirectsController extends AdminController
{
    /**
     * @return string|null
     */
    protected function abilityPrefix(): ?string
    {
        return 'seo-redirects';
    }

    /**
     * @param  ButtonsContainerInterface  $buttonsContainer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function form(ButtonsContainerInterface $buttonsContainer)
    {
        $this->authorizeForAction('import');

        $this->addBreadcrumb(__('cms-seo::admin.redirects.Redirects'));
        $this->addBreadcrumb(__('cms-seo::admin.redirects.Redirects import'));
        $this->pageName->setPageName(__('cms-seo::admin.redirects.Redirects import'));

        $upload = ButtonsMaker::save()->setIcon('fa-upload')->setName(__('cms-seo::admin.redirects.Import'));
        $buttonsContainer->add($upload)->add(ButtonsMaker::close(route('admin.seo-redirects.index')));

        $this->renderJsValidator(new ImportRedirectsRequest());

        return view('cms-seo::admin.redirects.import');
    }

    /**
     * @param  ImportRedirectsRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(ImportRedirectsRequest $request)
    {
        $import = new SeoRedirectsImport();
        $import->import($request->file('file'));

        $errors = $import->errors();
        if ($errors->isNotEmpty()) {
            logger()->debug('Import errors', [
                'errors' => $errors->map(function (\Exception $e) {
                    return $e->getMessage();
                })->toArray()
            ]);
        }

        flash()->success(__('cms-seo::admin.redirects.Import successfully completed'));

        return redirect()->route('admin.seo-redirects.index');
    }
}
