<?php

namespace App\Filament\Admin\Resources\AuthorResource\Pages;

use App\Filament\Admin\Resources\AuthorResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Created an Author')
            ->body('You have successfully created an author.');
    }
}
