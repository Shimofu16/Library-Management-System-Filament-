<?php

namespace App\Filament\Librarian\Resources\BorrowBookResource\Pages;

use App\Filament\Librarian\Resources\BorrowBookResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateBorrowBook extends CreateRecord
{
    protected static string $resource = BorrowBookResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Borrowed a Book')
            ->body('You have successfully borrowed a book.');
    }
}
