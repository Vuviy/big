@php
$colors = [
    (object)[
        'color' => '#959CAD',
        'textColor' => 'white',
        'var' => '$color-pantone-gray'
    ],
    (object)[
        'color' => '#C7CCD4',
        'textColor' => 'white',
        'var' => '$color-pantone-gray2'
    ],
    (object)[
        'color' => '#F1E846',
        'textColor' => 'black',
        'var' => '$color-pantone-lemon2'
    ],
    (object)[
        'color' => '#FFC700',
        'textColor' => 'black',
        'var' => '$color-pantone-orange'
    ],
    (object)[
        'color' => '#262728',
        'textColor' => 'white',
        'var' => '$color-base-strong'
    ],
    (object)[
        'color' => '#7D7E80',
        'textColor' => 'white',
        'var' => '$color-faint-strong'
    ],
    (object)[
        'color' => '#EBF0F5',
        'textColor' => 'black',
        'var' => '$color-faint-weak'
    ],
    (object)[
        'color' => '#3DA2FF',
        'textColor' => 'black',
        'var' => '$color-accent-strong'
    ],
    (object)[
        'color' => '#1ABF70',
        'textColor' => 'black',
        'var' => '$color-success-strong'
    ],
]
@endphp
<div class="_grid _grid--2 _xs:grid--4 _md:grid--6 _def:grid--8">
    @foreach($colors as $color)
        @include('cms-ui::partials.demo.color-item', [
            'color' => $color->color,
            'textColor' => $color->textColor,
            'var' => $color->var
        ])
    @endforeach
</div>
