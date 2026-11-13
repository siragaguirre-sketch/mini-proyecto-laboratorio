<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Notifications/Notification.php';
require_once __DIR__ . '/../src/Legacy/LegacyNotifier.php';
require_once __DIR__ . '/../src/Legacy/LegacyNotifierAdapter.php';
require_once __DIR__ . '/../src/Notifications/NotificationSender.php';

use PHPUnit\Framework\TestCase;

final class FactoryTest extends TestCase
{
    public function testCreateEmailNotificationReturnsEmailInstanceAndSendsMessage(): void
    {
        $notification = NotificationFactory::create('email', 'paciente@mail.com');

        $this->assertInstanceOf(EmailNotification::class, $notification);

        ob_start();
        $notification->send('Pedido #101 confirmado');
        $output = ob_get_clean();

        $this->assertSame('[EMAIL] paciente@mail.com: Pedido #101 confirmado', $output);
    }

    public function testCreateSmsNotificationReturnsSmsInstanceAndSendsMessage(): void
    {
        $notification = NotificationFactory::create('SMS', '555123456');

        $this->assertInstanceOf(SmsNotification::class, $notification);

        ob_start();
        $notification->send('Pedido #103 confirmado');
        $output = ob_get_clean();

        $this->assertSame('[SMS] 555123456: Pedido #103 confirmado', $output);
    }

    public function testCreateLegacyNotificationUsesAdapter(): void
    {
        $notification = NotificationFactory::create('legacy', 'paciente@legacy.com');

        $this->assertInstanceOf(LegacyNotifierAdapter::class, $notification);

        ob_start();
        $notification->send('Pedido #102 desde legado');
        $output = ob_get_clean();

        $this->assertSame('[LEGACY] Pedido #102 desde legado<br>', $output);
    }

    public function testCreateUnsupportedNotificationThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tipo de notificación no soportado: whatsapp');

        NotificationFactory::create('whatsapp', '555123456');
    }
}
