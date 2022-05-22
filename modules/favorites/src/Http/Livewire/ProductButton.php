<?php

namespace WezomCms\Favorites\Http\Livewire;

use Livewire\Component;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Favorites\Contracts\Favorable;
use WezomCms\Favorites\Contracts\FavoritesStorageInterface;
use WezomCms\Favorites\FavoriteManager;

/**
 * @property-read Favorable $favorable
 * @property-read FavoriteManager|FavoritesStorageInterface $storage
 */
class ProductButton extends Component
{
    /**
     * @var string
     */
    protected $view = 'cms-favorites::site.livewire.product-button';

    /**
     * @var string
     */
    public $payload;

    /**
     * @var bool
     */
    public $isFavorite;

    /**
     * @param  Favorable  $favorable
     */
    public function mount(Favorable $favorable)
    {
        $this->payload = $favorable->favorablePayload();
        $this->isFavorite = $this->storage->contains($favorable);
    }

    /**
     * @return array
     */
    protected function getListeners(): array
    {
        return [
            'favorableAdded:' . $this->payload => 'refreshComponent',
            'favorableRemoved:' . $this->payload => 'refreshComponent'
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view($this->view, [
            'isFavorite' => $this->isFavorite
        ]);
    }

    public function add()
    {
        if ($favorable = $this->favorable) {
            $this->storage->add($favorable);
            $this->isFavorite = true;
            $this->emit('favorableAdded');
            $this->emit('favorableAdded:' . $this->payload);

            JsResponse::make()
                ->modal(['content' => view('cms-ui::modals.response-info', [
                    'text' => __('cms-favorites::site.Product added to favorites')
                ])->render()])
                ->emit($this);
        } else {
            JsResponse::make()->success(false)
                ->notification(__('cms-favorites::site.Favorable not found'), 'warning')
                ->emit($this);
        }
    }

    public function remove()
    {
        if ($favorable = $this->favorable) {
            $this->storage->remove($favorable);
            $this->isFavorite = false;
            $this->emit('favorableRemoved');
            $this->emit('favorableRemoved:' . $this->payload);
        } else {
            JsResponse::make()->success(false)
                ->notification(__('cms-favorites::site.Favorable not found'), 'warning')
                ->emit($this);
        }
    }

    /**
     * Refresh isFavorite state
     */
    public function refreshComponent()
    {
        $this->isFavorite = $this->storage->contains($this->favorable);
    }

    /**
     * @return FavoritesStorageInterface|FavoriteManager
     */
    public function getStorageProperty()
    {
        return app('favorites');
    }

    /**
     * @return mixed
     */
    public function getFavorableProperty()
    {
        return $this->storage->decryptPayload($this->payload);
    }
}
