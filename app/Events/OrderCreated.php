<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderCreated
{
    use SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
