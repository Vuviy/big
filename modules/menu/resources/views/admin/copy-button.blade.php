@php
/**
 * @var $item \WezomCms\Menu\Models\Menu
 */
$groups = config('cms.menu.menu.groups');
if (array_key_exists($item->group, $groups)) {
    unset($groups[$item->group]);
}
@endphp
@if(count($groups) > 1)
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle rounded-0" type="button" id="copy-menu-{{ $item->id }}"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="@lang('cms-menu::admin.Copy')"><i class="fa fa-copy"></i></button>
        <div class="dropdown-menu" aria-labelledby="copy-menu-{{ $item->id }}">
            @foreach($groups as $position => $group)
                <a href="{{ route('admin.menu.copy', [$item->id, $position]) }}" class="dropdown-item">{{ Lang::get($group['name']) }}</a>
            @endforeach
        </div>
    </div>
@endif
