<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                @langTabs
                    <div class="form-group">
                        {!! Form::label(str_slug($locale . '[published]'), __('cms-core::admin.layout.Published')) !!}
                        {!! Form::status($locale . '[published]', old($locale . '.published', $obj->exists ? $obj->translateOrNew($locale)->published : true))  !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[name]', __('cms-menu::admin.Name')) !!}
                        {!! Form::text($locale . '[name]', old($locale . '.name', $obj->translateOrNew($locale)->name)) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[url]', __('cms-menu::admin.Url')) !!}
                        {!! Form::text($locale . '[url]', old($locale . '.url', $obj->translateOrNew($locale)->url)) !!}
                    </div>
                @endLangTabs
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('group', __('cms-menu::admin.Group')) !!}
                    {!! Form::select('group', $groups, old('group', $obj->group ?: request()->get('group')), ['class' => 'js-menu-group-selector']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('parent_id', __('cms-menu::admin.Parent')) !!}
                    {!! Form::select('parent_id', $tree, old('parent_id', $obj->parent_id ?: request()->get('parent_id')), ['class' => 'js-select2 js-menu-parent-selector']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
