<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Events/OrderObserver.php';
require_once __DIR__ . '/../src/Events/OrderEvents.php';

use App\Models\Order;
use PHPUnit\Framework\TestCase;

final class ObserverTest extends TestCase
{
    public function testNotifiesSubscribedObserverWhenOrderIsCreated(): void
    {
        $order = new Order(201, 'Ana', 700.0, 'obra_social');
        $observer = $this->createMock(OrderObserver::class);
        $observer->expects($this->once())
            ->method('update')
            ->with($this->identicalTo($order));

        $events = new OrderEvents();
        $events->subscribe($observer);
        $events->pedidoCreado($order);
    }

    public function testDoesNotNotifyObserverAfterUnsubscribe(): void
    {
        $order = new Order(202, 'Luis', 500.0, 'jubilado');
        $observer = $this->createMock(OrderObserver::class);
        $observer->expects($this->never())->method('update');

        $events = new OrderEvents($observer);
        $events->unsubscribe($observer);
        $events->pedidoCreado($order);
    }
}
