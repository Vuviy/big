<?php

namespace WezomCms\Catalog\Commands;

use Illuminate\Console\Command;
use WezomCms\Catalog\Jobs\KaspiFeedGeneration;

class KaspiGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kaspi-feed:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'All products feed';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        KaspiFeedGeneration::dispatch();

        $this->info('Done');
    }
}
