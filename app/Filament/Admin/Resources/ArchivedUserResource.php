<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ArchivedUserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ArchivedUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?string $navigationLabel = 'Archived Users';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::onlyTrashed()->count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'roles.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Role' => $record->roles->pluck('name')->implode(', '),
            'Email' => $record->email,
        ];
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->disabled()
                            ->columnSpan('full')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->disabled()
                            ->columnSpan('full')
                            ->email(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        // dd(static::getModel()::onlyTrashed()->get());
        return $table
            ->query(fn () => static::getModel()::onlyTrashed()) // Fetch only soft-deleted users
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Archived At')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                // TrashedFilter::make(), // Retain the TrashedFilter, but only soft-deleted users will show
            ])
            ->actions([

                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->restore(); // Restore the soft-deleted user
                        Notification::make()
                            ->title('User restored successfully.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArchivedUsers::route('/'),
        ];
    }
}
