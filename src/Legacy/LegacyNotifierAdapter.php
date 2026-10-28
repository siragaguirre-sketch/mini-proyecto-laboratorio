<?php

final class LegacyNotifierAdapter implements Notification
{
    public function __construct(private LegacyNotifier $legacyNotifier) {}

    public function send(string $message): void
    {
        $this->legacyNotifier->sendMessage($message);
    }
}
