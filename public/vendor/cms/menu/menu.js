$(document).ready(function () {
    var groupSelector = '.js-menu-group-selector';
    var parentSelector = '.js-menu-parent-selector';
    var $groupSelector = $(groupSelector);
    var $parentSelector = $(parentSelector);

    if ($groupSelector.length === 0 || $parentSelector.length === 0) {
        return;
    }

    $groupSelector.on('change', function (e) {
        var $this = $(this);

        if (!$this.val()) {
            $parentSelector.find('option:not(:first)').remove();
            return;
        }

        axios.get(route('admin.menu.get-parents-list', {id: $this.val(), group: $this.val()}))
            .then(function (response) {
                var options = '';
                $.each(response.data.options, function (key, option) {
                    options += '<option value="' + option.id + '">' + option.name + '</option>';
                });

                $parentSelector.html(options);
            });
    });
});
