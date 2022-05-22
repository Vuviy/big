<div class="modal"
     x-data="app.alpine.modal()"
     x-on:open-modal.window="open"
     x-on:preload-modal.window="preload"
     x-on:close-modal.window="close"
     x-on:keydown.escape.window="close"
     x-show="isOpen"
     x-ref="modal"
     x-cloak
     tabindex="-1"
>
    <div class="modal-box"
         x-ref="content"
         x-show.transition="isShow"
    ></div>
    <button class="modal-close button"
            type="button"
            x-el:button-close
            x-on:click="close"
            hidden
    >
        <span class="icon icon--size-xs">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" width="15" height="15">
                <path d="M0.250419 1.90034L1.90033 0.250421L16.7496 15.0997L15.0997 16.7496L0.250419 1.90034Z"></path>
                <path d="M15.0997 0.250423L16.7496 1.90034L1.90033 16.7496L0.250419 15.0997L15.0997 0.250423Z"></path>
            </svg>
        </span>
    </button>
    <div class="modal-preload">
        <svg viewBox="22 22 44 44" width="25" height="25">
            <circle cx="44" cy="44" r="20.2" fill="none" stroke-width="3.6"></circle>
        </svg>
    </div>
</div>
