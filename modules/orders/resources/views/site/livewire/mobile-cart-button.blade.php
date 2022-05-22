@php
    /**
     * @var $count int
     */
@endphp
<div x-data="app.alpine.appBarCartButton()"
     x-on:set-appbar-cart-name.window="setName($event.detail)"
>
    <div x-on:click="open();$dispatch('open-modal',{name:'orders.cart-popup'});$dispatch('set-appbar-name','cart')"
         x-show="!isShow()"
    >
        <div>{{ $count }}</div>
    </div>
    <div x-on:click="close();$dispatch('close-modal');"
         x-show="isShow()"
         x-cloak
    >
        &Cross;
    </div>
</div>
