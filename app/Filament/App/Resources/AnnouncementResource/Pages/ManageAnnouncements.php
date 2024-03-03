<?php

namespace App\Filament\App\Resources\AnnouncementResource\Pages;

use App\Filament\App\Resources\AnnouncementResource;
use App\Models\Announcement;
use App\Traits\HasResidentsNotifications;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ManageRecords;

class ManageAnnouncements extends ManageRecords
{
    use HasResidentsNotifications;

    protected static string $resource = AnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->after(function (Announcement $record) {
                    $residents = Filament::getTenant()->loadMissing('residents')->residents;

                    $notificationType = match ($record->priority) {
                        'low' => 'info',
                        'medium' => 'warning',
                        'high' => 'error',
                    };

                    $this->sendNotificationToResidents(
                        recipients: $residents,
                        notificationType: $notificationType,
                        notificationTitle: $record->title,
                        notificationBody: $record->description,
                    );
                }),
        ];
    }
}
