<div class="card">
    <div class="card-body">
        <dl>
            <dt>@lang('cms-newsletter::admin.Locale')</dt>
            <dd>{{ array_get($locales, $obj->locale) }}</dd>

            <dt>@lang('cms-newsletter::admin.Subject')</dt>
            <dd>{{ $obj->subject }}</dd>

            <dt>@lang('cms-newsletter::admin.Text')</dt>
            <dd>{!! $obj->text !!}</dd>
        </dl>
    </div>
</div>
