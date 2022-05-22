<?php

namespace WezomCms\Ui\Client;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class BrowsersListParser
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * BrowsersListParser constructor.
     *
     * @param  Filesystem  $filesystem
     * @param  string  $path
     */
    public function __construct(Filesystem $filesystem, $path = 'package.json')
    {
        $this->filesystem = $filesystem;
        $this->path = base_path($path);
    }

    /**
     * @param  string  $mode
     * @return mixed
     * @throws \Exception
     */
    public function get(string $mode)
    {
        if (null === $this->data) {
            $this->data = $this->parseData();
        }

        if (array_key_exists($mode, $this->data) === false) {
            throw new \Exception(sprintf('Unsupported mode [%s]', $mode));
        }

        return $this->data[$mode];
    }

    /**
     * @return array
     *
     * @throws FileNotFoundException
     */
    protected function parseData(): array
    {
        return collect(array_get(json_decode($this->filesystem->get($this->path), true), 'browserslist', []))
            ->filter()
            ->mapWithKeys(function ($items, $group) {
                return [$group => array_filter(array_map([$this, 'parseRowRule'], $items))];
            })->all();
    }

    /**
     * @param  string  $item
     * @return array
     */
    protected function parseRowRule(string $item): array
    {
        $item = preg_replace('/\s{2,}/', ' ', $item);

        $parts = explode(' ', $item);

        if (count($parts) === 3) {
            return [
                'browser' => $this->normalizeBrowser($parts[0]),
                'operator' => $parts[1],
                'version' => (int)$parts[2],
            ];
        } elseif (count($parts) === 2) {
            return [
                'browser' => $this->normalizeBrowser($parts[0]),
                'operator' => '=',
                'version' => (int)$parts[1],
            ];
        } else {
            return [];
        }
    }

    /**
     * @param  string  $name
     * @return string
     */
    protected function normalizeBrowser(string $name): string
    {
        return str_replace(
            ['ie'],
            ['Internet Explorer'],
            $name
        );
    }
}
