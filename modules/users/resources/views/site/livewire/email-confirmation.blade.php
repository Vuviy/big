<div class="modal-content" @mousedown.away="isShow && close($event)">
    <div class="text _fz-xxs _fw-bold _uppercase _mb-sm">
        @lang('cms-users::site.Подтверждение электронной почты')
    </div>
    <div class="text _fz-xs _color-black _mb-sm">
        @lang('cms-users::site.Для того чтобы завершить регистрацию, пожалуйста, пройдите по ссылке которая была отправлена на указанный вами электронный адрес')
    </div>
    <div class="text _fz-xxxs _color-pantone-gray _mb-xs">
        @lang('cms-users::site.Если вы не получили письмо отправьте запрос еще раз')
    </div>
    <div>
        <a href="#" class="link link--theme-gray" wire:click="resend">
            <span class="link__text text _fz-xs">
                @lang('cms-users::site.Подтвердить электронный адрес')
            </span>
        </a>
    </div>
</div>
