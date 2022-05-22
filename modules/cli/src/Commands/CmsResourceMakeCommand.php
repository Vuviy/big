<?php

namespace WezomCms\Cli\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CmsResourceMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:cms-resource
                            {name : Resource name}
                            {module : Module name}
                            {--m|multilingual : Model is multilingual}
                            {--f|filter : Need generate ModelFilter}
                            {--s|sort : Model must be sortable}
                            {--dir=modules : Directory name with modules}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new CMS resource (CRUD)';

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

        if (!$this->checkModule($module, $destination)) {
            return;
        }

        $modulePath = $destination . '/' . $module;

        $multilingual = (bool)$this->option('multilingual');
        $filter = (bool)$this->option('filter');
        $sort = (bool)$this->option('sort');

        // generate model
        $modelClass = $this->generateModel($modulePath, $multilingual, $filter);
        if ($multilingual) {
            $this->generateModelTranslation($modulePath, $modelClass);
        }
        if ($filter) {
            $this->generateModelFilter($modulePath, $modelClass, $multilingual);
        }
        $this->generateFactory($modulePath, $modelClass);

        $this->generateMigrations($modulePath, $modelClass, $multilingual);

        // generate http
        $formRequestClass = $this->generateAdminRequest($modulePath, $modelClass, $multilingual);
        $this->generateAdminController($modulePath, $modelClass, $formRequestClass, $sort);
        $this->generateSiteController($modulePath, $modelClass);

        // generate views
        $this->generateAdminViews($modulePath, $modelClass, $multilingual, $sort);
        $this->generateSiteViews($modulePath);
    }

    /**
     * @param  string  $modulePath
     * @param  bool  $multilingual
     * @param  bool  $filter
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateModel(string $modulePath, bool $multilingual, bool $filter): string
    {
        $namespace = $this->ns('Models');
        $name = Str::of($this->argument('name'))->studly()->singular();

        $dir = $modulePath . '/src/Models';

        $stub = 'model';
        if ($multilingual) {
            $stub .= '-translatable';
        }
        if ($filter) {
            $stub .= '-filterable';
        }

        $this->generate($dir, $name, 'model/' . $stub, ['DummyNamespace' => $namespace, 'DummyClass' => $name]);

        return $name;
    }

    /**
     * @param  string  $modulePath
     * @param  string  $modelClass
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateModelTranslation(string $modulePath, string $modelClass)
    {
        $name = $modelClass . 'Translation';

        $this->generate(
            $modulePath . '/src/Models',
            $name,
            'model/model-translation',
            [
                'DummyNamespace' => $this->ns('Models'),
                'DummyClass' => $name,
            ]
        );
    }

    /**
     * @param  string  $modulePath
     * @param  string  $modelClass
     * @param  bool  $multilingual
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateModelFilter(string $modulePath, string $modelClass, bool $multilingual)
    {
        $name = $modelClass . 'Filter';

        $this->generate(
            $modulePath . '/src/ModelFilters',
            $name,
            'model/model-filter' . ($multilingual ? '-translatable' : ''),
            [
                'DummyNamespace' => $this->ns('ModelFilters'),
                'NamespacedDummyModel' => $this->ns('Models', $modelClass),
                'DummyModel' => $modelClass,
                'DummyClass' => $name,
            ]
        );
    }

    /**
     * @param  string  $modulePath
     * @param  string  $modelClass
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateFactory(string $modulePath, string $modelClass)
    {
        $this->generate(
            $modulePath . '/database/factories',
            $modelClass . 'Factory',
            'model/factory',
            [
                'NamespacedDummyModel' => $this->ns('Models', $modelClass),
                'DummyModel' => $modelClass,
            ]
        );
    }

    /**
     * @param  string  $modulePath
     * @param  string  $modelClass
     * @param  bool  $multilingual
     */
    protected function generateMigrations(string $modulePath, string $modelClass, bool $multilingual)
    {
        $table = Str::of($modelClass)->pluralStudly()->snake();

        $migrationsFullPath = "{$modulePath}/database/migrations";

        $this->prepareDestination($migrationsFullPath);

        // Create base table migration
        $this->createMigration($migrationsFullPath, "create_{$table}_table");

        // If multilingual create additional migration and add foreign id to base table
        if ($multilingual) {
            $singularBaseTable = Str::singular($table);

            $migrationName = "create_{$singularBaseTable}_translations_table";

            $this->createMigration($migrationsFullPath, $migrationName);

            $this->addForeignIdToMigration($migrationsFullPath, $migrationName, "{$singularBaseTable}_id");
        }
    }

    /**
     * @param  string  $migrationsFullPath
     * @param  string  $name
     * @param  string|null  $path
     */
    protected function createMigration(string $migrationsFullPath, string $name, ?string $path = null)
    {
        if (count(glob("{$migrationsFullPath}/*_{$name}.php")) === 0) {
            $this->call('make:migration', [
                'name' => $name,
                '--path' => $path ?: $this->option('dir') . '/' .  $this->argument('module') . '/database/migrations',
            ]);
        }
    }

    /**
     * Add foreign id to to translations table migration.
     *
     * @param  string  $migrationsFullPath
     * @param  string  $migrationName
     * @param  string  $foreignId
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function addForeignIdToMigration(string $migrationsFullPath, string $migrationName, string $foreignId)
    {
        $filePath = array_get($this->files->glob("{$migrationsFullPath}/*_{$migrationName}.php"), 0);
        if (!$filePath) {
            return;
        }

        $space = str_repeat(' ', 12);

        $content = $this->files->get($filePath);

        // Add columns
        $content = str_replace(
            '$table->id();',
            '$table->id();' . "\n" .
            $space . '$table->foreignId(\'' . $foreignId . '\')->constrained()->cascadeOnDelete();' . "\n" .
            $space . '$table->string(\'locale\')->index();' . "\n" .
            $space . '$table->string(\'name\');',
            $content
        );

        // Replace timestamps to unique index
        $content = str_replace(
            '$table->timestamps();',
            '$table->unique([\'' . $foreignId . '\', \'locale\']);',
            $content
        );

        $this->files->put($filePath, $content);
    }

    /**
     * @param  string  $modulePath
     * @param  string  $modelClass
     * @param  bool  $multilingual
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateAdminRequest(string $modulePath, string $modelClass, bool $multilingual): string
    {
        $name = $modelClass . 'Request';

        $stub = 'http/admin-request';
        if ($multilingual) {
            $stub .= '-localized';
        }

        $this->generate(
            $modulePath . '/src/Http/Requests/Admin',
            $name,
            $stub,
            [
                'DummyNamespace' => $this->ns('Http', 'Requests', 'Admin'),
                'DummyClass' => $name,
            ]
        );

        return $name;
    }

    /**
     * @param  string  $modulePath
     * @param  string  $modelClass
     * @param  string  $formRequestClass
     * @param  bool  $sort
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateAdminController(
        string $modulePath,
        string $modelClass,
        string $formRequestClass,
        bool $sort
    ) {
        $name = $modelClass . 'Controller';

        $stub = 'http/admin-controller';
        if ($sort) {
            $stub .= '-sortable';
        }

        $this->generate(
            $modulePath . '/src/Http/Controllers/Admin',
            $name,
            $stub,
            [
                'DummyNamespace' => $this->ns('Http', 'Controllers', 'Admin'),
                'NamespacedDummyFormRequest' => $this->ns('Http', 'Requests', 'Admin', $formRequestClass),
                'NamespacedDummyModel' => $this->ns('Models', $modelClass),
                'DummyClass' => $name,
                'DummyModel' => $modelClass,
                'DummyViewPath' => "cms-{$this->argument('module')}::admin.{$this->kebabResourceName()}",
                'DummyRouteName' => 'admin.' . $this->kebabResourceName(),
                'DummyFormRequest' => $formRequestClass,
            ]
        );
    }

    /**
     * @param  string  $modulePath
     * @param  string  $modelClass
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateSiteController(string $modulePath, string $modelClass)
    {
        $name = $modelClass . 'Controller';

        $this->generate(
            $modulePath . '/src/Http/Controllers/Site',
            $name,
            'http/site-controller',
            [
                'DummyNamespace' => $this->ns('Http', 'Controllers', 'Site'),
                'NamespacedDummyModel' => $this->ns('Models', $modelClass),
                'DummyClass' => $name,
            ]
        );
    }

    /**
     * @param  string  $modulePath
     * @param  string  $modelClass
     * @param  bool  $multilingual
     * @param  bool  $sort
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateAdminViews(
        string $modulePath,
        string $modelClass,
        bool $multilingual,
        bool $sort
    ) {
        $dir = $modulePath . '/resources/views/admin/' . $this->kebabResourceName();

        // index
        $this->generate(
            $dir,
            'index.blade',
            'views/admin/index' . ($sort ? '-sortable' : ''),
            ['NamespacedDummyModel' => $this->ns('Models', $modelClass)]
        );

        // form
        $this->generate(
            $dir,
            'form.blade',
            'views/admin/form' . ($multilingual ? '-translatable' : ''),
            ['NamespacedDummyModel' => $this->ns('Models', $modelClass)]
        );
    }

    /**
     * @param  string  $modulePath
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generateSiteViews(string $modulePath)
    {
        $name = $this->kebabResourceName() . '.blade';

        $destination = "{$modulePath}/resources/views/site";

        if ($this->confirm("Create frontend view file [{$destination}/{$name}.php]?", true)) {
            $this->generate($destination, $name, 'views/site/index');
        }
    }

    /**e
     * @param  string  $dir
     * @param  string  $name
     * @param  string  $stub
     * @param  array  $replace
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function generate(string $dir, string $name, string $stub, array $replace = []): bool
    {
        $file = "{$dir}/{$name}.php";
        if (!$this->checkExistPath($file)) {
            return false;
        }

        if (!empty($replace)) {
            $content = str_replace(
                array_keys($replace),
                array_values($replace),
                $this->files->get($this->stubs($stub))
            );
        } else {
            $content = $this->files->get($this->stubs($stub));
        }

        $this->prepareDestination($dir);

        $this->touch($file);

        $this->files->put($file, $content);

        return true;
    }

    /**
     * @param  string  $module
     * @param  string  $destination
     * @return bool
     */
    protected function checkModule(string $module, string $destination): bool
    {
        if (file_exists($destination . '/' . $module)) {
            return true;
        }

        if ($this->confirm("Module [{$module}] doesnt exists by path {$destination}. Create new module?", true)) {
            $this->call('make:module', ['module' => $module, '--dir' => $this->option('dir')]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param  string  $path
     * @return bool
     */
    protected function checkExistPath(string $path): bool
    {
        if (!file_exists($path)) {
            return true;
        }

        return $this->confirm("File [{$path}] already exists. Override?", false);
    }

    /**
     * @param  string  $destination
     */
    protected function prepareDestination(string $destination)
    {
        if (!$this->files->isDirectory($destination)) {
            $this->files->makeDirectory($destination, 0755, true);
        }
    }

    /**
     * @param  string|null  $stub
     * @return string
     */
    protected function stubs(?string $stub = null): string
    {
        return __DIR__ . '/../../stubs/cms-resource/' . ltrim($stub, '/') . '.stub';
    }

    /**
     * Create empty file if doesnt exists.
     *
     * @param  string  $file
     */
    protected function touch(string $file)
    {
        if (!is_file($file)) {
            touch($file);
        }
    }

    /**
     * @param  mixed  $parts
     * @return string
     */
    protected function ns(...$parts)
    {
        return implode('\\', array_filter(array_merge(
            [
            'WezomCms',
            Str::studly($this->argument('module')),
            ],
            $parts
        )));
    }

    /**
     * Convert any module name format to kebab-case.
     *
     * @return string
     */
    protected function kebabResourceName(): string
    {
        return Str::of($this->argument('name'))->studly()->kebab()->plural();
    }
}
