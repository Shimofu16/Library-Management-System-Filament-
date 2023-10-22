<?php

namespace App\Filament\Librarian\Resources;

use Filament\Forms;
use App\Models\Book;
use Filament\Tables;
use App\Models\Borrower;
use Filament\Forms\Form;
use App\Models\BorrowBook;
use Filament\Tables\Table;
use App\Enums\BookStatusEnum;

use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Librarian\Resources\BorrowBookResource\Pages;
use App\Filament\Librarian\Resources\BorrowBookResource\RelationManagers;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class BorrowBookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Borrower Management';

    protected static ?string $navigationLabel = 'Borrow Books';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('borrower_id')
                            ->options(Borrower::pluck('name', 'id')->toArray())
                            ->required(),
                        DatePicker::make('borrowed_date')
                            ->required(),
                        DatePicker::make('due_date')
                            ->required(),
                        MarkdownEditor::make('notes')
                            ->disableAllToolbarButtons()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('author.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('stock')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bookShelf.shelf.number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('bookShelf.row')
                    ->searchable()
                    ->sortable(),
                SelectColumn::make('status')
                    ->options(BookStatusEnum::toArray())
                    ->rules(['required'])
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Filter::make('publication_date')
                    ->form([
                        DatePicker::make('published_from'),
                        DatePicker::make('published_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('publication_date', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('publication_date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): string {
                        if (!$data['published_from'] && !$data['published_until']) {
                            return 'Any';
                        }

                        if ($data['published_from'] && !$data['published_until']) {
                            return 'From ' . $data['published_from'];
                        }

                        if (!$data['published_from'] && $data['published_until']) {
                            return 'Until ' . $data['published_until'];
                        }

                        return $data['published_from'] . ' - ' . $data['published_until'];
                    })
                    ->label('Publication Date'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    ->label('Borrow Book'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make('Book Information')
                    ->schema([
                        ImageEntry::make('cover')
                            ->disk('public')
                            ->visibility('public')
                            ->extraAttributes(['loading' => 'lazy'])
                            ->square(),
                        TextEntry::make('title'),
                        TextEntry::make('author.name'),
                        TextEntry::make('isbn'),
                        TextEntry::make('publisher.name'),
                        TextEntry::make('publication_date')
                            ->dateTime('M d, Y'),
                        TextEntry::make('genre')
                            ->listWithLineBreaks()
                            ->bulleted(),
                        TextEntry::make('synopsis')
                            ->columnSpanFull(),

                    ])
                    ->columns(4),
                ComponentsSection::make('Book Inventory')
                    ->schema([
                        TextEntry::make('stock'),
                        TextEntry::make('bookShelf.shelf.number'),
                        TextEntry::make('bookShelf.row'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Available' => 'success',
                                'Not Available' => 'info',
                                'Out of Stock' => 'danger',
                            })

                    ])
                    ->columns(4)
            ]);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBorrowBooks::route('/'),
            'create' => Pages\CreateBorrowBook::route('/create'),
            'edit' => Pages\EditBorrowBook::route('/{record}/edit'),
        ];
    }
}
