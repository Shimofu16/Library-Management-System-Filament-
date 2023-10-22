<?php

namespace App\Filament\Librarian\Resources\BorrowedBookResource\Pages;

use App\Filament\Librarian\Resources\BorrowedBookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBorrowedBooks extends ListRecords
{
    protected static string $resource = BorrowedBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
