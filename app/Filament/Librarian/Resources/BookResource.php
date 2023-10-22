<?php

namespace App\Filament\Librarian\Resources;

use Filament\Forms;
use App\Models\Book;
use Filament\Tables;
use App\Models\Shelf;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\BookGenreEnum;
use App\Enums\BookStatusEnum;
use Filament\Infolists\infolist;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Date;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\BookResource\Pages;
use App\Filament\Admin\Resources\BookResource\RelationManagers;
use Filament\Infolists\Components\Section as ComponentsSection;
use App\Filament\Librarian\Resources\BookResource\Pages\EditBook;
use App\Filament\Librarian\Resources\BookResource\Pages\ListBooks;
use App\Filament\Librarian\Resources\BookResource\Pages\CreateBook;
use App\Filament\Librarian\Resources\BookResource\RelationManagers\BorrowedBooksRelationManager;
use Filament\Notifications\Notification;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

      protected static ?string $navigationGroup = 'Book Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Book Information')
                            ->columns(2)
                            ->schema([
                                TextInput::make('title')
                                    ->autofocus()
                                    ->required()
                                    ->placeholder('Enter the book title')
                                    ->label('Title'),
                                Select::make('author_id')
                                    ->required()
                                    ->relationship('author', 'name')
                                    ->placeholder('Enter the book author')
                                    ->label('Author'),
                                TextInput::make('isbn')
                                    ->required()
                                    ->placeholder('Enter the book ISBN')
                                    ->label('ISBN'),
                                Select::make('publisher_id')
                                    ->required()
                                    ->relationship('publisher', 'name')
                                    ->placeholder('Enter the book publisher')
                                    ->label('Publisher'),
                                DatePicker::make('publication_date')
                                    ->required()
                                    ->placeholder('Enter the book publication date')
                                    ->label('Publication Date'),
                                Select::make('genre')
                                    ->required()
                                    ->options(BookGenreEnum::toArray())
                                    ->multiple()
                                    ->placeholder('Enter the book Genre')
                                    ->label('Genre'),
                                MarkdownEditor::make('synopsis')
                                    ->required()
                                    ->placeholder('Enter the book synopsis')
                                    ->label('Synopsis')
                                    ->columnSpan(2),
                                FileUpload::make('cover')
                                    ->required()
                                    ->directory('book covers')
                                    ->visibility('public')
                                    ->image()
                                    ->placeholder('Enter the book cover')
                                    ->label('Cover')
                                    ->columnSpan(2),

                            ]),
                    ]),
                Group::make()
                    ->schema([
                        Section::make('Book Inventory')
                            ->columns(2)
                            ->schema([
                                TextInput::make('stock')
                                    ->required()
                                    ->integer()
                                    ->placeholder('Enter the book stock')
                                    ->label('Stock'),
                                Select::make('shelf_id')
                                    ->required()
                                    ->options(Shelf::all()->pluck('number', 'id')->toArray())
                                    ->placeholder('Enter the book shelf')
                                    ->label('Shelf'),
                                Select::make('row')
                                    ->required()
                                    ->options(range(1, 5))
                                    ->placeholder('Enter the book Row')
                                    ->label('Row'),
                            ]),
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

                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->successNotification(
                            Notification::make()
                                ->title('Deleted a Book')
                                ->body('You have successfully soft deleted a book')
                        ),
                    Tables\Actions\RestoreAction::make()
                        ->successNotification(
                            Notification::make()
                                ->title('Restored a Book')
                                ->body('You have successfully restored a book')
                        ),
                    Tables\Actions\ForceDeleteAction::make()
                        ->successNotification(
                            Notification::make()
                                ->title('Permanently Deleted a Book')
                                ->body('You have successfully permanently deleted a book')
                        ),
                ])
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
            BorrowedBooksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBooks::route('/'),
            'create' => CreateBook::route('/create'),
            'edit' => EditBook::route('/{record}/edit'),
        ];
    }
}
