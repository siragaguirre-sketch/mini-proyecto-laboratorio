<?php

final class OrderEvents
{
    /** @var OrderObserver[] */
    private array $observers;

    public function __construct(OrderObserver ...$observers)
    {
        $this->observers = $observers;
    }

    public function subscribe(OrderObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function unsubscribe(OrderObserver $observer): void
    {
        foreach ($this->observers as $index => $subscribedObserver) {
            if ($subscribedObserver === $observer) {
                unset($this->observers[$index]);
                $this->observers = array_values($this->observers);
                return;
            }
        }
    }

    public function pedidoCreado(Order $order): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($order);
        }
    }
}
