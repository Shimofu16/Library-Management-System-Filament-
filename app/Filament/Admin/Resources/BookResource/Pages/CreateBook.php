<?php

namespace App\Filament\Admin\Resources\BookResource\Pages;

use App\Filament\Admin\Resources\BookResource;
use App\Models\Book;
use App\Models\BookShelf;
use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;
    public $book_shelf;

    protected function handleRecordCreation(array $data): Model
    {

        $this->book_shelf = [
            'shelf_id' => $data['shelf_id'],
            'row' => $data['row'],
        ];
        return static::getModel()::create($data);
    }


    protected function afterCreate()
    {
        BookShelf::create([
            'book_id' => $this->record->id,
            'shelf_id' => $this->book_shelf['shelf_id'],
            'row' => $this->book_shelf['row'],
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Created a Book')
            ->body('You have successfully created a book.');
    }
}
