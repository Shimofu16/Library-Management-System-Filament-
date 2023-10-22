<?php

namespace App\Filament\Librarian\Resources\BorrowBookResource\Pages;

use App\Filament\Librarian\Resources\BorrowBookResource;
use App\Models\BorrowedBook;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBorrowBook extends EditRecord
{
    public $book_id;

    protected static string $resource = BorrowBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return route('filament.librarian.resources.borrowed-books.index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Borrowed a Book ')
            ->body('You have successfully borrowed a book.');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->book_id = $this->record->id;
        $stock = $this->record->stock - 1;
        if ($stock < 0) {
            $stock = 0;
        }
        $this->record->update([
            'stock' => $stock,
        ]);
        $data['borrowed_date'] = now()->format('Y-m-d');
        $data['due_date'] = now()->addDays(7)->format('Y-m-d');


        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $data['book_id'] = $this->book_id;
        BorrowedBook::create($data);
        return $record;
    }

}
