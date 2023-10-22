<?php

namespace App\Filament\Librarian\Resources\BorrowedBookResource\Pages;

use App\Filament\Librarian\Resources\BorrowedBookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBorrowedBook extends CreateRecord
{
    protected static string $resource = BorrowedBookResource::class;
}
