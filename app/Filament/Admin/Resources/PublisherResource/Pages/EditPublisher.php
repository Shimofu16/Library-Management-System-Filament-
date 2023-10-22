<?php

namespace App\Filament\Admin\Resources\PublisherResource\Pages;

use App\Filament\Admin\Resources\PublisherResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPublisher extends EditRecord
{
    protected static string $resource = PublisherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getUpdateNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Updated a Publisher')
            ->body('You have successfully updated a publisher.');
    }
}
