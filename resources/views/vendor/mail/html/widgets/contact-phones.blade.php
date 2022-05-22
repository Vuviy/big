<p>
    @lang('cms-ui::site.mail.Всегда ответим на Ваши вопросы')
    <br>
    @if($phones)
        <strong>
            @foreach($phones as $phone)
                <a href="tel:{{ preg_replace('/[^\d\+]/', '', $phone) }}">{{ trim($phone) }}</a>@if(!$loop->last), @endif
            @endforeach
        </strong>
    @endif
    <br>
    <span>
        <a target="_blank" href="{{ $url }}"><u>{{ $url }}</u></a>
    </span>
</p>
