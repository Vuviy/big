<?php

namespace WezomCms\Orders\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use WezomCms\Orders\Models\Order;

interface ExpectsResponse
{
    /**
     * @param  Order  $order
     * @return Response|JsonResponse
     */
    public function successResponse(Order $order);

    /**
     * @param  Order  $order
     * @return Response|JsonResponse
     */
    public function failedResponse(Order $order);
}
