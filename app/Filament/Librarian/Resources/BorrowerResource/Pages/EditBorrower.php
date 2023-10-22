<?php

namespace App\Filament\Librarian\Resources\BorrowerResource\Pages;

use App\Filament\Librarian\Resources\BorrowerResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditBorrower extends EditRecord
{
    protected static string $resource = BorrowerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Updated a Borrower')
            ->body('You have successfully updated a borrower.');
    }
}
