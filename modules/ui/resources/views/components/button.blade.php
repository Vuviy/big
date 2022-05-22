@php

    /**
     * @var array|null $attrs
     * @var array|null $icon [icon, width[number], height[number], right[bool]]
     * @var string|null $component HtmlElement
     * @var string|null $classes
     * @var string|null $text
     * @var string[]|null $modificators
     */

    $_mainClass = 'button';
    $_component = $component ?? 'div';

    $_hasIcon = isset($icon) && count($icon);
    if ($_hasIcon) {
        $_iconRight = $icon[4] ?? false;
        $icon_modifier = $icon[5] ?? '';
        $_iconClass = 'button__icon button__icon--' . ($_iconRight ? 'right' : 'left') . ' ' . $icon_modifier;
    }

    $modificators = $modificators ?? [];
    $_bemModifier = '';

    foreach ($modificators as $modificator) {
        $_bemModifier = $_bemModifier . ' ' . $_mainClass . '--' . $modificator;
    }

@endphp

<{{ $_component }} {!! Html::attributes($attrs ?? []) !!} class="{{ $_mainClass . $_bemModifier }} {{ $classes ?? '' }}">
    @if ($_hasIcon && !$_iconRight)
        <span class="{{ $_iconClass }}">
            @svg($icon[0], $icon[1] ?? null, $icon[2] ?? null)
        </span>
    @endif
    @if ($text ?? false)
		<span class="{{ $_mainClass }}__text">{!! $text !!}</span>
    @endif
    @if ($_hasIcon && $_iconRight)
        <span class="{{ $_iconClass }}">
            @svg($icon[0], $icon[1] ?? null, $icon[2] ?? null)
        </span>
    @endif
</{{ $_component }}>
