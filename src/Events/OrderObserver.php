<?php

use App\Models\Order;

interface OrderObserver
{
    public function update(Order $order): void;
}
