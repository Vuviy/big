<?php

namespace WezomCms\Sitemap;

use Illuminate\Console\Scheduling\Schedule;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Sitemap\Commands\SitemapCommand;

class SitemapServiceProvider extends BaseServiceProvider
{
    /**
     * Register console commands.
     */
    public function registerCommands()
    {
        $this->commands(SitemapCommand::class);
    }

    /**
     * Register jobs.
     *
     * @param  Schedule  $schedule
     */
    public function jobs(Schedule $schedule)
    {
        $schedule->command('sitemap:generate')->dailyAt('05:00');
    }
}
