<?php

namespace App\Filament\Librarian\Resources\BookResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Librarian\Resources\BookResource;
use App\Models\Book;
use Filament\Resources\Pages\ListRecords\Tab;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    protected function getBooksByStatusCount($status)
    {
        return BookResource::getModel()::where('status', $status)->count();
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'all';
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Books')
                ->modifyQueryUsing(fn (Builder $query) => $query)
                ->badge(Book::count(), 'gray'),
            'available' => Tab::make('Available')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'available'))
                ->badge($this->getBooksByStatusCount('available'), 'green'),
            'not available' => Tab::make('Not Available')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'not available'))
                ->badge($this->getBooksByStatusCount('not available'), 'red'),
            'out of stock' => Tab::make('Out of Stock')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'out of stock'))
                ->badge($this->getBooksByStatusCount('out of stock'), 'red'),
        ];
    }
}
