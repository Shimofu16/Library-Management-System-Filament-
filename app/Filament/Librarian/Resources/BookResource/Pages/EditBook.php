<?php

namespace App\Filament\Librarian\Resources\BookResource\Pages;

use App\Filament\Librarian\Resources\BookResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;
    public $book_shelf;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['row'] = $this->record->bookShelf->row;
        $data['shelf_id'] = $this->record->bookShelf->shelf_id;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $this->book_shelf = [
            'shelf_id' => $data['shelf_id'],
            'row' => $data['row'],
        ];
        $record->update($data);

        return $record;
    }

    protected function afterUpdate()
    {
        $this->record->bookShelf->update([
            'row' => $this->book_shelf['row'],
            'shelf_id' => $this->book_shelf['shelf_id'],
        ]);
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getUpdateNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Updated a Book')
            ->body('You have successfully updated a book.');
    }
}
