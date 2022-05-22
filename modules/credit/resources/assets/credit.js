$(document).ready(function () {
    var $homeCreditSendDeliveredStatusButton = $('#home-credit-send-delivered-status-button');
    var $homeCreditSendCanceledStatusButton = $('#home-credit-send-canceled-status-button');

    $homeCreditSendCanceledStatusButton.on('click', function () {
        sendChangeLoanApplicationStatus($(this).data('order-payment-information-id'), $(this).data('status'))
    });

    $homeCreditSendDeliveredStatusButton.on('click', function () {
        sendChangeLoanApplicationStatus($(this).data('order-payment-information-id'), $(this).data('status'))
    });
});

function sendChangeLoanApplicationStatus(orderPaymentInformationId, status) {
    axios.post(route('admin.change-loan-application-status', {
        'order_payment_information': orderPaymentInformationId,
        'status': status,
    }))
        .then((response) => {
            document.location.reload();
        });
}
