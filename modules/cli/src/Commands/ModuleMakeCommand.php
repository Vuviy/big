<?php

namespace WezomCms\Cli\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ModuleMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module
                            {module : Module name}
                            {--dir=modules : Directory name with modules}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module file structure';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param  Filesystem  $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $module = $this->argument('module');
        $destination = app()->basePath($this->option('dir'));

        if (file_exists($destination . '/' . $module) && is_dir($destination . '/' . $module)) {
            $this->warn("Module [{$module}] already exists by path {$destination}");
            return;
        }

        $this->prepareDestination($destination);

        $zip = new \ZipArchive();
        $zip->open($this->stubs('module.zip'));
        $zip->extractTo($this->stubs());

        // Move extracted files
        $this->files->move($this->stubs('module'), "{$destination}/{$module}");

        $directory = "{$destination}/{$module}";
        $this->files->move("{$directory}/config/config.php.stub", "{$directory}/config/{$module}.php");

        $this->translations($destination, $module);

        $this->serviceProvider($destination, $module);

        $this->composer($destination, $module);

        $this->info("Module [{$module}] successfully extracted to {$destination}");
    }

    /**
     * @param  string|null  $stub
     * @return string
     */
    protected function stubs(?string $stub = null): string
    {
        return __DIR__ . '/../../stubs/' . $stub;
    }

    /**
     * @param  string  $destination
     * @param  string  $module
     */
    protected function translations(string $destination, string $module)
    {
        $stubDirectory = "{$destination}/{$module}/resources/lang/locale";
        $source = "{$stubDirectory}/default.php.stub";

        foreach (app('locales') as $locale => $language) {
            $directory = "{$destination}/{$module}/resources/lang/{$locale}";
            $this->prepareDestination($directory);

            $this->files->copy($source, "{$directory}/default.php");
        }

        $this->files->delete($source);
        $this->files->deleteDirectory($stubDirectory);
    }

    /**
     * @param  string  $destination
     * @param  string  $module
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function serviceProvider(string $destination, string $module)
    {
        $className = Str::studly($module) . 'ServiceProvider';

        $source = "{$destination}/{$module}/src/service-provider.php.stub";

        $content = $this->files->get($source);

        $replace = [
            'DummyNamespace' => 'WezomCms\\' . Str::studly($module),
            'DummyClass' => $className,
        ];

        $content = str_replace(array_keys($replace), array_values($replace), $content);

        $this->files->put($source, $content);

        $this->files->move($source, "{$destination}/{$module}/src/{$className}.php");
    }

    /**
     * @param  string  $destination
     * @param  string  $module
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function composer(string $destination, string $module)
    {
        $className = Str::studly($module) . 'ServiceProvider';

        $source = "{$destination}/{$module}/composer.json.stub";

        $content = $this->files->get($source);

        $coreVersion = config('cms.core.main.version');

        $replace = [
            'dummy_module' => $module,
            'DummyNamespace' => 'WezomCms\\\\' . Str::studly($module),
            'DummyServiceProvider' => $className,
            'DummyVersion' => $coreVersion,
            'DummyCoreDependencyVersion' => '^' . preg_replace('/\.\d+$/', '', $coreVersion),
        ];

        $content = str_replace(array_keys($replace), array_values($replace), $content);

        $this->files->put($source, $content);

        $this->files->move($source, "{$destination}/{$module}/composer.json");
    }

    /**
     * @param  string  $destination
     */
    protected function prepareDestination(string $destination)
    {
        if (!$this->files->isDirectory($destination)) {
            $this->files->makeDirectory($destination);
        }
    }
}
