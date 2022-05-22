@php
    /**
     * @var $buttons \Illuminate\Support\Collection|\WezomCms\Core\Contracts\ButtonInterface[]
     */
@endphp
<div>
    <a style="border: 2px solid red; background: lightgrey; padding: 5px" href="xmltest">Завантажити файл</a>
@foreach($buttons as $button)
        {!! $button->render() !!}
    @endforeach
</div>
