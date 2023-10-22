<?php

namespace App\Filament\Librarian\Resources\BorrowedBookResource\Pages;

use App\Filament\Librarian\Resources\BorrowedBookResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditBorrowedBook extends EditRecord
{
    protected static string $resource = BorrowedBookResource::class;

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
            ->title('Borrowed a Book ')
            ->body('You have successfully borrowed a book.');
    }

    
}
