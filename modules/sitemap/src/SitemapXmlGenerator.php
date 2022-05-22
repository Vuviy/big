<?php

namespace WezomCms\Sitemap;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Localizable;
use Mcamara\LaravelLocalization\LaravelLocalization;
use WezomCms\Core\Contracts\SitemapXmlGeneratorInterface;
use XMLWriter;

class SitemapXmlGenerator implements SitemapXmlGeneratorInterface
{
    use Localizable;

    public const DIRNAME = 'public';
    public const MAX_LINKS = 50000;

    /**
     * @var XMLWriter
     */
    protected $xml;

    /**
     * @var array
     */
    protected $registeredUrls = [];

    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $tempFile;

    /**
     * @var array
     */
    protected $locales;

    /**
     * @var int
     */
    protected $linksCount = 0;

    /**
     * @var int
     */
    protected $additionalFiles = 0;

    /**
     * @var array
     */
    protected $filenames = [];

    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * Sitemap constructor.
     * @param  string  $file
     * @param  LaravelLocalization  $laravelLocalization
     * @param  Filesystem  $filesystem
     */
    public function __construct(
        string $file,
        LaravelLocalization $laravelLocalization,
        Filesystem $filesystem
    ) {
        $this->file = $file;

        // Set default locale first
        $defaultLocale = $laravelLocalization->getDefaultLocale();

        $locales = app('locales');
        uksort($locales, function ($item) use ($defaultLocale) {
            return $item === $defaultLocale ? -1 : 1;
        });

        $this->locales = $locales;
        $this->xml = new XMLWriter();
        $this->filesystem = $filesystem;
    }

    /**
     * @return $this
     */
    public function start(): SitemapXmlGeneratorInterface
    {
        $this->xml->openUri($this->tempFile = $this->generateTempName());

        $this->xml->startDocument('1.0', 'utf-8');
        $this->xml->startElement('urlset');
        $this->xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $this->xml->writeAttributeNs('xmlns', 'xhtml', null, 'http://www.w3.org/1999/xhtml');

        return $this;
    }

    /**
     * @param  string|array|mixed|callable  $url
     * @return SitemapXmlGeneratorInterface
     */
    public function add($url): SitemapXmlGeneratorInterface
    {
        $url = is_iterable($url) ? $url : func_get_args();

        foreach ($url as $item) {
            if (is_callable($item)) {
                $rows = [];
                foreach ($this->locales as $locale => $language) {
                    $this->withLocale($locale, function () use (&$rows, $locale, $item) {
                        $result = call_user_func($item, $locale);

                        foreach (is_iterable($result) ? $result : [$result] as $key => $value) {
                            $rows[$key][$locale] = $value;
                        }
                    });
                }

                foreach ($rows as $rowItem) {
                    $this->writeUrl(array_first($rowItem), function () use ($rowItem) {
                        foreach ($rowItem as $locale => $href) {
                            $this->xml->startElementNs('xhtml', 'link', null);
                            $this->xml->writeAttribute('rel', 'alternate');
                            $this->xml->writeAttribute('hreflang', $locale);
                            $this->xml->writeAttribute('href', \LaravelLocalization::getLocalizedURL($locale, $href));
                            $this->xml->endElement();

                            $this->registeredUrls[] = $href;
                        }
                    });
                }
            } else {
                $this->writeUrl($item);
            }
        }

        return $this;
    }

    /**
     * @param  array|string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return SitemapXmlGeneratorInterface
     */
    public function addLocalizedRoute($name, $parameters = [], $absolute = true): SitemapXmlGeneratorInterface
    {
        return $this->add(function () use ($name, $parameters, $absolute) {
            return route_localized($name, $parameters, $absolute);
        });
    }

    /**
     * @return void
     */
    public function save()
    {
        $this->xml->endElement();
        $this->xml->endDocument();
        $this->xml->flush();

        if ($this->additionalFiles > 0) {
            $this->filenames[$this->tempFile] = $this->generateNumberedName($this->additionalFiles + 1);

            $this->createIndexFile();

            foreach ($this->filenames as $tempFile => $filename) {
                $this->filesystem->move($tempFile, $filename);
            }
        } else {
            $this->filesystem->move($this->tempFile, $this->file);
        }
    }

    public function __destruct()
    {
        $this->filesystem->delete($this->tempFile);
        foreach ($this->filenames as $tempFile => $filename) {
            $this->filesystem->delete($tempFile);
        }
    }

    /**
     * @param  string  $url
     * @return bool
     */
    public function have(string $url): bool
    {
        return in_array($url, $this->registeredUrls);
    }

    /**
     * @param  string  $url
     * @return bool
     */
    public function doesNotHave(string $url): bool
    {
        return !$this->have($url);
    }

    /**
     * @param  string  $url
     * @param  callable|null  $callback
     */
    protected function writeUrl(string $url, callable $callback = null): void
    {
        if ($this->shouldCreateNewFile()) {
            $this->createNewFile();
        }

        $this->xml->startElement('url');
        $this->xml->writeElement('loc', $url);

        if (null !== $callback) {
            $callback();
        }

        $this->xml->endElement();
        $this->linksCount++;
    }

    /**
     * @return bool
     */
    protected function shouldCreateNewFile(): bool
    {
        return (int) ($this->linksCount / static::MAX_LINKS) !== $this->additionalFiles;
    }

    protected function createNewFile(): void
    {
        $this->xml->endElement();
        $this->xml->endDocument();
        $this->xml->flush();

        $this->filenames[$this->tempFile] = $this->generateNumberedName(++$this->additionalFiles);

        $this->start();
    }

    protected function createIndexFile(): void
    {
        $this->xml->openUri($this->tempFile = $this->generateTempName());

        $this->xml->startDocument('1.0', 'utf-8');
        $this->xml->startElement('sitemapindex');
        $this->xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($this->filenames as $filename) {
            $this->xml->startElement('sitemap');
            $this->xml->writeElement('loc', url('/' . $filename));
            $this->xml->writeElement('lastmod', date(DATE_W3C));
            $this->xml->endElement();
        }

        $this->xml->endElement();
        $this->xml->endDocument();
        $this->xml->flush();

        $this->filesystem->move($this->tempFile, $this->file);
    }

    /**
     * @return string
     */
    protected function generateTempName(): string
    {
        return storage_path(Str::random() . '.xml');
    }

    /**
     * @param  int  $number
     * @return string|string[]|null
     */
    protected function generateNumberedName(int $number): string
    {
        return preg_replace(
            '/(\w*?)(\.xml)/',
            '${1}' . $number . '$2',
            $this->file
        );
    }
}
