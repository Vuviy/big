<?php

namespace WezomCms\Ui\Client;

use Browser;
use Exception;

class ModernBrowserChecker
{
    public const MODERN = 'modern';
    public const LEGACY = 'legacy';

    /**
     * @var BrowsersListParser
     */
    protected $browsersListParser;

    /**
     * ModernBrowserChecker constructor.
     *
     * @param  BrowsersListParser  $browsersListParser
     */
    public function __construct(BrowsersListParser $browsersListParser)
    {
        $this->browsersListParser = $browsersListParser;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isModern(): bool
    {
        return $this->checkVersion($this->browsersListParser->get(ModernBrowserChecker::MODERN));
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isLegacy(): bool
    {
        return !$this->isModern();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function mode(): string
    {
        return $this->isModern() ? ModernBrowserChecker::MODERN : ModernBrowserChecker::LEGACY;
    }

    /**
     * @param  array  $rules
     * @return bool
     */
    protected function checkVersion(array $rules): bool
    {
        [$family, $version] = $this->getBrowserInformation();

        foreach ($rules as $rule) {
            if (mb_strtolower($rule['browser']) === mb_strtolower($family)) {
                switch ($rule['operator']) {
                    case '=':
                        return $version === $rule['version'];
                    case '>=':
                        return $version >= $rule['version'];
                    case '>':
                        return $version > $rule['version'];
                    case '<=':
                        return $version <= $rule['version'];
                    case '<':
                        return $version < $rule['version'];
                    default:
                        return false;
                }
            }
        }

        return false;
    }

    /**
     * @return array
     */
    protected function getBrowserInformation(): array
    {
        $family = Browser::browserFamily();

        $family = str_replace(['Mobile', 'Webview', 'Microsoft'], '', $family);

        return [trim($family), Browser::browserVersionMajor()];
    }
}
