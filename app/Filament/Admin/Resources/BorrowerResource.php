<?php

namespace App\Filament\Admin\Resources;

use App\Enums\BorrowerGradeLevelEnum;
use App\Filament\Admin\Resources\BorrowerResource\Pages;
use App\Filament\Admin\Resources\BorrowerResource\RelationManagers;
use App\Models\Borrower;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BorrowerResource extends Resource
{
    protected static ?string $model = Borrower::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Borrower Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Borrower information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->required(),
                        DatePicker::make('birth_date')
                            ->date()
                            ->required(),
                        TextInput::make('phone_number')
                            ->tel()
                            ->required(),
                        TextInput::make('address')
                            ->required(),
                        TextInput::make('school')
                            ->required(),
                        Select::make('grade_level')
                            ->options(BorrowerGradeLevelEnum::toArray())
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('phone_number')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('school')
                    ->searchable(),
                TextColumn::make('grade_level')
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->successNotification(
                            Notification::make()
                                ->title('Deleted a Borrower')
                                ->body('You have successfully soft deleted a borrower')
                        ),
                    Tables\Actions\RestoreAction::make()
                        ->successNotification(
                            Notification::make()
                                ->title('Restored a Borrower')
                                ->body('You have successfully restored a borrower')
                        ),
                    Tables\Actions\ForceDeleteAction::make()
                        ->successNotification(
                            Notification::make()
                                ->title('Permanently Deleted a Borrower')
                                ->body('You have successfully permanently deleted a borrower')
                        ),
                ])
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
            'index' => Pages\ListBorrowers::route('/'),
            'create' => Pages\CreateBorrower::route('/create'),
            'edit' => Pages\EditBorrower::route('/{record}/edit'),
        ];
    }
}
