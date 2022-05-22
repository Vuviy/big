<?php

namespace WezomCms\Favorites\Http\Livewire;

use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Traits\BreadcrumbsTrait;
use WezomCms\Favorites\Contracts\Favorable;
use WezomCms\Favorites\Contracts\FavoritesStorageInterface;
use WezomCms\Favorites\Enums\SortVariant;
use WezomCms\Favorites\FavoriteManager;
use WezomCms\Favorites\Storage\DatabaseStorage;

class FavoritesList extends Component
{
    use SEOTools;
    use WithPagination;
    use BreadcrumbsTrait;

    protected $listeners = [
        'favorableAdded' => '$refresh',
        'favorableRemoved' => '$refresh'
    ];

    /**
     * Per page limit.
     *
     * @var int
     */
    public $limit;

    /**
     * Count loaded pages.
     *
     * @var int
     */
    public $loads = 1;

    /**
     * Selected sort variant.
     *
     * @var string|null
     */
    public $sort;

    /**
     * List with payloads that are already displayed on the page.
     *
     * @var array
     */
    public $rendered = [];

    /**
     * List with selected payloads. Used for removing.
     * @var array
     */
    public $selected = [];

    /**
     * @var bool
     */
    public $selectAllChecked = false;

    public function mount()
    {
        $this->limit = settings('favorites.site.limit', 10);
    }

    /**
     * @return mixed
     */
    public function render()
    {
        $this->setSeo();

        $items = $this->items();

        $result = $items->take($this->limit * $this->loads);

        $this->rendered = $result->map(function (Favorable $favorable) {
            return $favorable->favorablePayload();
        })->values()->all();

        if (empty($this->selected)) {
            $this->selectAllChecked = false;
        } elseif (count($this->rendered) === count($this->selected)) {
            $this->selectAllChecked = true;
        } else {
            $this->selectAllChecked = false;
        }

        return view('cms-favorites::site.livewire.favorites-list', [
            'result' => $result,
            'hasMore' => $result->count() < $items->count(),
            'cabinetPage' => $this->cabinetPage(),
            'selectAllChecked' => $this->selectAllChecked,
        ])->extends($this->layout());
    }

    public function loadMore()
    {
        $this->loads++;
    }

    public function selectAll()
    {
        if ($this->selectAllChecked) {
            $this->selectAllChecked = false;
            $this->selected = [];
            $this->reset('selected');
        } else {
            $this->selectAllChecked = true;
            $this->selected = $this->rendered;
        }
    }

    public function delete()
    {
        if (empty($this->selected)) {
            JsResponse::make()
                ->notification(__('cms-favorites::site.Please select at least one product'), 'warning')
                ->emit($this);
            return;
        }

        foreach ($this->selected as $payload) {
            $this->getStorage()->remove($this->getStorage()->decryptPayload($payload));
        }

        $this->reset('selected');

        $this->emit('favorableRemoved');
    }

    protected function setSeo()
    {
        $pageName = settings('favorites.site.name');

        $this->seo()
            ->setPageName($pageName)
            ->setTitle(settings('favorites.site.title'));

        if ($this->cabinetPage()) {
            $this->addBreadcrumb(settings('users.cabinet.name'), route('cabinet'));
        }

        $this->addBreadcrumb($pageName, route('favorites'));
    }

    /**
     * @return Collection
     */
    protected function items(): Collection
    {
        $items = $this->getStorage()->getAll();

        switch ($this->sort) {
            case SortVariant::CHEAP:
                $items = $items->sortBy('cost');
                break;
            case SortVariant::EXPENSIVE:
                $items = $items->sortByDesc('cost');
                break;
            case SortVariant::NOVELTY:
                $items = $items->sortByDesc('novelty');
                break;
            case SortVariant::TOP:
            default:
                $items = $items->sortByDesc('popular');
        }

        return $items;
    }

    /**
     * @return FavoritesStorageInterface|FavoriteManager
     */
    protected function getStorage()
    {
        return app('favorites');
    }

    /**
     * @return bool
     */
    protected function cabinetPage(): bool
    {
        return app('favorites.store') instanceof DatabaseStorage;
    }

    /**
     * @return string
     */
    protected function layout(): string
    {
        return $this->cabinetPage() ? 'cms-users::site.layouts.cabinet' : 'cms-ui::layouts.main';
    }
}
