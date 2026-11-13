<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Notifications/Notification.php';
require_once __DIR__ . '/../src/Legacy/LegacyNotifier.php';
require_once __DIR__ . '/../src/Legacy/LegacyNotifierAdapter.php';

use PHPUnit\Framework\TestCase;

final class AdapterTest extends TestCase
{
    public function testAdapterTranslatesSendCallToLegacyNotifier(): void
    {
        $adapter = new LegacyNotifierAdapter(new LegacyNotifier());

        ob_start();
        $adapter->send('Pedido #301 creado');
        $output = ob_get_clean();

        $this->assertSame('[LEGACY] Pedido #301 creado<br>', $output);
    }

    public function testAdapterRejectsMessageWithInvalidType(): void
    {
        $adapter = new LegacyNotifierAdapter(new LegacyNotifier());

        $this->expectException(TypeError::class);

        $adapter->send(301);
    }
}
