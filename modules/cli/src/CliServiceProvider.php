<?php

namespace WezomCms\Cli;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use WezomCms\Core\BaseServiceProvider;

class CliServiceProvider extends BaseServiceProvider
{
    public function registerCommands()
    {
        $commands = collect(Finder::create()->in($this->root('src/Commands'))->name('*Command.php'))
            ->map(function (SplFileInfo $file) {
                return 'WezomCms\\Cli\\Commands\\' . $file->getBasename('.php');
            })->filter(function ($class) {
                try {
                    return class_exists($class);
                } catch (\Throwable $e) {
                    return false;
                }
            });

        $this->commands($commands->all());
    }
}
