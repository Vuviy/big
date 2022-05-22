export function costHandler(saleToggleSelector, costSelector, oldCostSelector) {
    let $toggle = $(saleToggleSelector || '.js-product-sale-toggle');
    let $cost = $(costSelector || '.js-product-cost');
    let $costWrapper = $cost.closest('.js-cost-wrapper');
    let $oldCost = $(oldCostSelector || '.js-product-old-cost');
    let $oldCostWrapper = $oldCost.closest('.js-old-cost-wrapper');
    let $percentage = $('.js-percentage-wrapper');

    if (!$toggle || !$cost || !$oldCost) {
        return;
    }

    function toggleVisibility(active) {
        if (active) {
            $oldCostWrapper.show();
            $costWrapper.removeClass('col-md-12').addClass('col-md-6');
            $percentage.show();
        } else {
            $costWrapper.removeClass('col-md-6').addClass('col-md-12');
            $oldCostWrapper.hide();
            $percentage.hide();
        }
    }

    toggleVisibility($toggle.is(':checked'));

    $toggle.change(function () {
        let $this = $(this);
        let cost = $cost.val();
        let oldCost = $oldCost.val();

        $cost.val(oldCost);
        $oldCost.val(cost);

        toggleVisibility($this.is(':checked'));
    });
}

export function discountCost() {
    let $cost = $('.js-product-cost');
    let $oldCost = $('.js-product-old-cost');
    let $percentage = $('.js-product-percentage');
    $('.js-product-discount').click(function () {
        return $cost.val(Math.ceil($oldCost.val() - ($oldCost.val() * ($percentage.val() / 100))));
    });
}

export function specifications() {
    var $specsContainer = $('#specifications-tab');
    if ($specsContainer.length === 0) {
        return;
    }

    $('#category_id').on('change', function () {
        var categoryId = this.value;

        axios.post(route('admin.products.specifications-widget', {
            product_id: $specsContainer.data('product-id'),
            category_id: categoryId
        }))
            .then(response => {
                $specsContainer.html(response.data.html);
                $('#primarySpecValues').data('url', response.data.primary_search_url);
                inits.ajaxSelect2($specsContainer.find('.js-ajax-select2'));
                inits.select2($specsContainer.find('.js-select2'));
            });
    });
}

export default {
    costHandler,
    discountCost,
    specifications
};
