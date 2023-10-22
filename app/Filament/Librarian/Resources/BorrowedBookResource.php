<?php

namespace App\Filament\Librarian\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;

use Filament\Tables\Table;
use App\Models\BorrowedBook;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Librarian\Resources\BorrowedBookResource\Pages;
use App\Filament\Librarian\Resources\BorrowedBookResource\RelationManagers;
use BladeUI\Icons\Components\Icon;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;

class BorrowedBookResource extends Resource
{
    protected static ?string $model = BorrowedBook::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Borrower Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('book_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('borrower_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('borrowed_date')
                    ->required(),
                Forms\Components\DatePicker::make('due_date')
                    ->required(),
                Forms\Components\DatePicker::make('returned_date'),
                Forms\Components\Toggle::make('is_returned')
                    ->required(),
                Forms\Components\TextInput::make('notes')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('book.title')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('borrower.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('borrowed_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('returned_date')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_returned')
                    ->boolean()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make('is_returned')
                    ->label('Return book')
                    ->icon('heroicon-o-book-open')
                    ->form([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                DatePicker::make('returned_date')->nullable()->requiredIf('is_returned', true),
                                Toggle::make('is_returned')->required()->default(fn ($record) => $record->is_returned),
                            ])
                    ])
                    ->action(function (array $data, $record) {
                        $stock = $record->book->stock + 1;
                        if ($record->book->stock >= $record->book->initial_stock) {
                            $stock = $record->book->initial_stock;
                        }
                        $record->book->update([
                            'stock' => $stock,
                        ]);
                        $record->update([
                            'returned_date' => $data['returned_date'],
                            'is_returned' => $data['is_returned'],
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBorrowedBooks::route('/'),
            'create' => Pages\CreateBorrowedBook::route('/create'),
            'edit' => Pages\EditBorrowedBook::route('/{record}/edit'),
        ];
    }
}
