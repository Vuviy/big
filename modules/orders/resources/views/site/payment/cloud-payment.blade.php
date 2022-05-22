@extends('cms-orders::site.layouts.checkout')
@php
    /**
     * @var $order \WezomCms\Orders\Models\Order
	 * @var $paymentData array
	 */
@endphp
@section('content', '')

@push('scripts')
    <script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            tryPay();

            function tryPay() {
                var widget = new cp.CloudPayments({language: '{{ str_replace('_', '-', LaravelLocalization::getCurrentLocaleRegional()) }}'});

                widget.pay('charge',
                    @json($paymentData),
                    {
                        onSuccess: function (options) {
                            //действие при успешной оплате
                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', '{{ $order->paymentCallbackUrl() }}');

                            xhr.onreadystatechange = function () {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    window.location.href = '{{ $order->thanksPageUrl() }}';
                                }
                            };

                            xhr.send();
                        },
                        onFail: function (reason, options) {
                            //действие при неуспешной оплате
                            window.location.href = '{{ $order->thanksPageUrl() }}';
                        },
                        onComplete: function (paymentResult, options) {
                            //Вызывается как только виджет получает от api.cloudpayments ответ с результатом транзакции.
                            //например вызов вашей аналитики Facebook Pixel
                        }
                    }
                )
            }
        });
    </script>
@endpush
