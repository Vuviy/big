<?php

namespace WezomCms\Sitemap\Commands;

use Exception;
use Illuminate\Console\Command;
use WezomCms\Sitemap\SitemapXmlGenerator;

class SitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $file = 'public/sitemap.xml';
        try {
            $sitemap = app(SitemapXmlGenerator::class, compact('file'));

            $sitemap->start();

            event('sitemap:xml', $sitemap);

            event('after-modules-sitemap:xml', $sitemap);

            $sitemap->save();
        } catch (Exception $e) {
            $this->error('Error to open stream for writing ' . $file);
            $this->error('Message: ' . $e->getMessage());

            return;
        }

        $this->info('Done');
    }
}
