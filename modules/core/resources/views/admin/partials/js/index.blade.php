@includeFirst(['cms-ui::admin.tiny-mce', 'cms-core::admin.partials.js.tiny-mce'])
@include('cms-core::admin.partials.js.translations')

<script>
    window.select2Templates = {};

    window.select2Templates['svg-select'] = function (state) {
        let data = state.data || $(state.element).data();

        if (data.description) {
            return $(`<span>${data.description}</span>`)
        }

        return $(`<svg class="_svg-spritemap__icon" width="20" height="20"><use xlink:href="{{ url('svg') }}/${data.sprite}.svg#${data.icon}"></use></svg>`)
    };
</script>
