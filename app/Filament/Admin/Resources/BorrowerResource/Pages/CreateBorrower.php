<?php

namespace App\Filament\Admin\Resources\BorrowerResource\Pages;

use App\Filament\Admin\Resources\BorrowerResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateBorrower extends CreateRecord
{
    protected static string $resource = BorrowerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Created a Borrower')
            ->body('You have successfully created a borrower.');
    }
}
