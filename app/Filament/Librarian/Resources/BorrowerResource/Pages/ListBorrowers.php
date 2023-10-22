<?php

namespace App\Filament\Librarian\Resources\BorrowerResource\Pages;

use App\Filament\Librarian\Resources\BorrowerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBorrowers extends ListRecords
{
    protected static string $resource = BorrowerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
