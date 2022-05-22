<?php

namespace WezomCms\Core\Commands\Translations;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Console\Command;
use Str;
use WezomCms\Core\Contracts\TranslationStorageInterface;
use WezomCms\Core\Enums\TranslationSide;
use WezomCms\Core\Models\Translation;

class ScanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:scan';

    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'Search new keys and update translation storage';

    /**
     * @var ConfigRepository
     */
    protected $config;
    /**
     * @var TranslationStorageInterface
     */
    protected $storage;

    /**
     * Translator constructor.
     * @param  ConfigRepository  $config
     * @param  TranslationStorageInterface  $storage
     */
    public function __construct(ConfigRepository $config, TranslationStorageInterface $storage)
    {
        $this->config = $config;
        $this->storage = $storage;

        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $newKeys = array_unique($this->getNewTranslationsKeys());

        if ($newKeys) {
            $this->line('Updating storage...');
            $this->storage->writeNewTranslations($newKeys);
            $this->info('Done!');
        } else {
            $this->info('Keys not found');
        }
        $this->line('');
    }

    /**
     * @return array
     */
    protected function getNewTranslationsKeys(): array
    {
        $translationKeys = $this->findProjectTranslationsKeys();

        $newKeys = [];
        foreach ($translationKeys as $key) {
            $parsedKey = Translation::parseKey($key);
            $side = array_get($parsedKey, 'side');

            if (!TranslationSide::hasValue($side)) {
                if (Str::startsWith($key, 'cms-')) {
                    $this->error("Unsupported side '{$side}'. Key: '{$key}'");
                }
                continue;
            }

            foreach (Translation::localesBySide($side) as $locale) {
                if (!$this->storage->hasSavedKey($parsedKey['namespace'], $side, $parsedKey['key'], $locale)) {
                    $this->warn("Missing key '{$key}', locale '{$locale}'");
                    $newKeys[] = $key;
                }
            }
        }
        return $newKeys;
    }

    /**
     * @return array
     */
    protected function findProjectTranslationsKeys()
    {
        $allKeys = [];
        $eventData = event('translator:view_directories');
        $eventData = collect($eventData)->flatten()->unique()->filter();

        foreach ($eventData as $directory) {
            $this->getTranslationKeysFromDir($allKeys, $directory);
        }

        foreach (array_filter(event('translator:find_keys')) as $customKeys) {
            $allKeys = array_merge($allKeys, $customKeys);
        }

        $allKeys = array_unique($allKeys);

        ksort($allKeys);

        return $allKeys;
    }

    /**
     * @param  array  $keys
     * @param  string  $dirPath
     * @param  string  $fileExt
     */
    protected function getTranslationKeysFromDir(&$keys, $dirPath, $fileExt = 'php')
    {
        $files = glob_recursive("{$dirPath}/*.{$fileExt}", GLOB_BRACE);

        foreach ($files as $file) {
            $content = $this->getSanitizedContent($file);

            foreach ($this->config->get('cms.core.translations.call_functions', []) as $function) {
                $this->getTranslationKeysFromFunction($keys, $function, $content);
            }
        }
    }

    /**
     * @param  array  $keys
     * @param  string  $functionName
     * @param  string  $content
     */
    protected function getTranslationKeysFromFunction(&$keys, $functionName, $content)
    {
        $matches = [];
        preg_match_all("#{$functionName}\((.*?)\)#", $content, $matches);

        if (!empty($matches)) {
            foreach ($matches[1] as $match) {
                $strings = [];
                preg_match('#^\s*?\'(.*?)\'#', str_replace('"', "'", $match), $strings);

                if (!empty($strings)) {
                    $keys[] = $strings[1];
                }
            }
        }
    }

    /**
     * @param  string  $filePath
     * @return string
     */
    protected function getSanitizedContent($filePath)
    {
        return str_replace("\n", ' ', file_get_contents($filePath));
    }
}
