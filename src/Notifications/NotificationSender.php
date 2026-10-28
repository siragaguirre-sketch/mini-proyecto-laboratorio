<?php

final class EmailNotification implements Notification
{
    public function __construct(private string $to) {}

    public function send(string $message): void
    {
        echo "[EMAIL] {$this->to}: {$message}";
    }
}

final class SmsNotification implements Notification
{
    public function __construct(private string $to) {}

    public function send(string $message): void
    {
        echo "[SMS] {$this->to}: {$message}";
    }
}

final class NotificationFactory
{
    public static function create(string $type, string $destino): Notification
    {
        return match (strtolower($type)) {
            'email' => new EmailNotification($destino),
            'sms'   => new SmsNotification($destino),
            'legacy' => new LegacyNotifierAdapter(new LegacyNotifier()),
            default => throw new InvalidArgumentException("Tipo de notificación no soportado: {$type}"),
        };
    }
}

class NotificationSender
{
    public function enviar(string $tipo, string $destino, string $mensaje): void
    {
        // Delegamos la creación al Factory y ejecutamos el método uniforme de la interfaz
        $notification = NotificationFactory::create($tipo, $destino);
        $notification->send($mensaje);
    }
}
