<?php

namespace WezomCms\Ui;

use Html;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use WezomCms\Ui\Client\ModernBrowserChecker;

class Ui
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $svgManifest;

    /**
     * @var array
     */
    protected $srcManifest = [];

    /**
     * @var UrlGenerator
     */
    protected $urlGenerator;

    /**
     * @var ModernBrowserChecker
     */
    protected $modernBrowserChecker;

    /**
     * @var bool|null
     */
    protected $browserMode;

    /**
     * Ui constructor.
     *
     * @param  Application  $app
     * @param  Filesystem  $filesystem
     * @param  UrlGenerator  $urlGenerator
     * @param  ModernBrowserChecker  $modernBrowserChecker
     *
     * @throws FileNotFoundException
     */
    public function __construct(
        Application $app,
        Filesystem $filesystem,
        UrlGenerator $urlGenerator,
        ModernBrowserChecker $modernBrowserChecker
    ) {
        $this->app = $app;

        $this->svgManifest = $this->readManifest($filesystem, config('cms.ui.ui.manifest_path.svg'));

        $this->urlGenerator = $urlGenerator;

        $this->modernBrowserChecker = $modernBrowserChecker;

        foreach ([ModernBrowserChecker::MODERN, ModernBrowserChecker::LEGACY] as $mode) {
            $this->srcManifest[$mode] = $this->readManifest(
                $filesystem,
                str_replace('{mode}', $mode, config('cms.ui.ui.manifest_path.src'))
            );
        }
    }

    /**
     * Render svg element.
     *
     * @param  string  $sprite
     * @param  string  $id
     * @param  int|string|array  $size  - Integer or array value - set size. String value - set class.
     * @param  string|null  $class
     * @param  array  $attributes
     * @return HtmlString
     */
    public function svg(
        string $sprite,
        string $id,
        $size = [],
        ?string $class = null,
        array $attributes = []
    ): HtmlString {
        $width = null;
        $height = null;
        if (is_array($size) && !empty($size)) {
            $width = $size[0];
            $height = $size[1];
        } elseif (is_string($size) && $class === null) {
            $class = $size;
        } elseif ($size) {
            $width = $size;
            $height = $size;
        }

        if (!isset($this->svgManifest[$sprite])) {
            if ($this->app->isProduction()) {
                return new HtmlString();
            }

            throw new \InvalidArgumentException("Missing SVG manifest for sprite: '{$sprite}'");
        }

        return new HtmlString(sprintf(
            '<svg%s><use xlink:href="%s#%s"></use></svg>',
            Html::attributes(array_merge(array_filter(compact('class', 'width', 'height')), $attributes)),
            $this->urlGenerator->asset($this->svgManifest[$sprite]),
            $id
        ));
    }

    /**
     * @param  string  $path
     * @return string
     * @throws \Exception
     */
    public function src(string $path): string
    {
        return $this->urlGenerator->asset($this->srcManifest[$this->getMode()][$path] ?? $path);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getMode(): string
    {
        if ($this->browserMode === null) {
            $this->browserMode = $this->modernBrowserChecker->mode();
        }

        return $this->browserMode;
    }

    /**
     * @param  string|null  $extension
     * @return array
     * @throws \Exception
     */
    public function manifestFiles(string $extension = null): array
    {
        $items = collect($this->srcManifest[$this->getMode()])->keys();

        if ($extension !== null) {
            $items = $items->filter(function ($name) use ($extension) {
                return Str::endsWith($name, $extension);
            });
        }

        return $items->all();
    }

    /**
     * @param  Filesystem  $filesystem
     * @param  string  $path
     * @return array
     * @throws FileNotFoundException
     */
    protected function readManifest(Filesystem $filesystem, string $path): array
    {
        if ($filesystem->exists($filePath = public_path($path))) {
            return json_decode($filesystem->get($filePath), true);
        }

        return [];
    }
}
