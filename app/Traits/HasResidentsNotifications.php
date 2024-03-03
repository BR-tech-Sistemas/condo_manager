<?php

namespace App\Traits;

use Filament\Notifications\Notification;
use Illuminate\Support\Collection;

trait HasResidentsNotifications
{
    /**
     * Send a notification to residents
     *
     * @param array|Collection $recipients
     * @param string $notificationType
     * @param string $notificationTitle
     * @param string|null $notificationBody
     * @return void
     */
    public function sendNotificationToResidents(
        array|Collection $recipients,
        string $notificationType,
        string $notificationTitle,
        ?string $notificationBody = null
    ): void
    {
        $typeAllowed = ['success', 'info', 'warning', 'error'];

        if (!in_array($notificationType, $typeAllowed)) {
            throw new \InvalidArgumentException('Invalid notification type');
        }

        foreach ($recipients as $recipient) {
            Notification::make()
                ->{$notificationType}()
                ->title($notificationTitle)
                ->body($notificationBody)
                ->sendToDatabase($recipient);
        }
    }
}