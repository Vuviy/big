<?php

namespace WezomCms\Orders\Events;

use Illuminate\Queue\SerializesModels;
use WezomCms\Orders\Models\Order;

class CreatedOrder
{
    use SerializesModels;

    /**
     * @var Order
     */
    public $order;

    /**
     * CreatedOrder constructor.
     * @param  Order  $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
