<?php

namespace App\Filament\Admin\Resources\PublisherResource\Pages;

use App\Filament\Admin\Resources\PublisherResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePublisher extends CreateRecord
{
    protected static string $resource = PublisherResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Created a Publisher')
            ->body('You have successfully created a publisher.');
    }
}
