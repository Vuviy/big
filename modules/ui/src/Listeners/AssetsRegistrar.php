<?php

namespace WezomCms\Ui\Listeners;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use WezomCms\Core\Contracts\Assets\AssetManagerInterface;
use WezomCms\Ui\Ui;

class AssetsRegistrar
{
    /**
     * @var AssetManagerInterface
     */
    private $assetManager;

    /**
     * @var array
     */
    protected $conditions = [];

    /**
     * @var Ui
     */
    protected $ui;

    /**
     * AssetsRegistrar constructor.
     * @param  AssetManagerInterface  $assetManager
     * @param  Filesystem  $filesystem
     * @param  Ui  $ui
     */
    public function __construct(AssetManagerInterface $assetManager, Filesystem $filesystem, Ui $ui)
    {
        $this->assetManager = $assetManager;

        try {
            $this->conditions = $filesystem->getRequire(dirname(__DIR__) . '/assets-conditions.php');
        } catch (FileNotFoundException $e) {
            //
        }

        $this->ui = $ui;
    }

    /**
     * @throws Exception
     */
    public function addCssToHead()
    {
        foreach ($this->filterByConditions($this->ui->manifestFiles('css')) as $index => $path) {
            $this->assetManager->addCss($this->ui->src($path))
                ->position(AssetManagerInterface::POSITION_HEAD)
                ->setSort($index)
                ->group(AssetManagerInterface::GROUP_SITE);
        }
    }

    /**
     * @throws Exception
     */
    public function addJsToBody()
    {
        foreach ($this->filterByConditions($this->ui->manifestFiles('js')) as $index => $path) {
            $this->assetManager->addJs($this->ui->src($path))
                ->position(AssetManagerInterface::POSITION_END_BODY)
                ->setSort($index)
                ->group(AssetManagerInterface::GROUP_SITE);
        }
    }

    /**
     * @param  array  $files
     * @return array
     */
    protected function filterByConditions(array $files): array
    {
        return array_filter($files, function ($file) {
            if (array_key_exists($file, $this->conditions) === false) {
                return true;
            }

            if (is_callable($this->conditions[$file])) {
                return app()->call($this->conditions[$file]) !== false;
            }

            return $this->conditions[$file];
        });
    }
}
