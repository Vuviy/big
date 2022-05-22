@php
    use Illuminate\Database\Eloquent\Model;
    /**
     * @var $obj Model
     * @var $text string|bool|null
     * @var $ability string|null
     * @var $route string|null
     * @var $target string|null
     */
     $text = $text ?? null;

     if (empty($ability)) {
         $ability = app(\WezomCms\Core\Contracts\PermissionsContainerInterface::class)->getModelAbility($obj, 'show');
     }
     if (empty($route)) {
         $route = 'admin.' . $ability;
     }
@endphp
@if($text === false)
    {{-- render icon --}}
    @if(Gate::allows($ability, $obj))
        <a href="{{ route($route, $obj) }}"
           class="btn btn-info" {!! $target ?? false ? 'target="' . $target . '"' : '' !!}
           title="@lang('cms-core::admin.layout.Browsing')"><i class="fa fa-eye"></i></a>
    @endif
@else
    @php($text = $text === null ? $obj->name : $text)
    {{-- render link --}}
    @can($ability, $obj)
        <a href="{{ route($route, $obj) }}"
           {!! $target ?? false ? 'target="' .  $target . '"' : '' !!}
           title="{{ $text }}" {!! $text !== null ? 'class="text-info"' : '' !!}>{{ $text !== null ? $text : __('cms-core::admin.layout.Not set') }}</a>
    @else
        <span title="{{ $text }}" {!! $text !== null ? 'class="text-info"' : '' !!}>{{ $text !== null ? $text : __('cms-core::admin.layout.Not set') }}</span>
    @endcan
@endif
