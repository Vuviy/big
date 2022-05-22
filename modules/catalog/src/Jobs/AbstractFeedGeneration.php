<?php

namespace WezomCms\Catalog\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use WezomCms\Catalog\Models\Category;

abstract class AbstractFeedGeneration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    abstract public function handle();

    /**
     * @return Collection
     */
    protected function categoriesIndex(): Collection
    {
        $categories = Category::get()->mapWithKeys(function (Category $category) {
            return [$category->id => $category];
        });

        return $categories->mapWithKeys(function (Category $category) use ($categories) {
            $id = $category->id;

            $path = collect([$category->name]);
            while ($category->parent_id > 0) {
                $parent = $categories[$category->parent_id];
                if (!$parent) {
                    break;
                }

                $path->push($parent->name);
                $category = $parent;
            }

            return [$id => $path->reverse()->implode(' > ')];
        });
    }
}
