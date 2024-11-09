<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ArchivedModuleResource\Pages;
use App\Models\ArchMod;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Response;

class ArchivedModuleResource extends Resource
{
    protected static ?string $model = ArchMod::class;

    protected static ?string $navigationGroup = 'Modules';

    protected static ?string $navigationLabel = 'Archived Modules';

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->disabled(), // Disable editing archived modules

                FileUpload::make('archive')
                    ->downloadable()
                    ->disabled() // Disable editing archived modules
                    ->label('Module File'),

                MultiSelect::make('sections')
                    ->relationship('sections', 'name')
                    ->reactive()
                    ->disabled() // Disable editing archived modules
                    ->label('Assign Sections'),

                TextInput::make('student_names')
                    ->label('Assigned Students')
                    ->disabled() // Auto-populated and disabled for editing
                    ->reactive(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn () => static::getModel()::onlyTrashed()) // Show only soft-deleted modules
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('sections.name'),
                IconColumn::make('archive')
                    ->label('Download PDF')
                    ->boolean()
                    ->trueIcon('heroicon-o-document')
                    ->action(fn (ArchMod $record) => Response::download($record->archive)) // Changed from Module to ArchMod
                    ->color('success'),
                TextColumn::make('deleted_at')
                    ->label('Archived At')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make()->default(true),
            ])
            ->actions([
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (ArchMod $record) { // Changed from Module to ArchMod
                        $record->restore();
                        Notification::make()
                            ->title('Module restored successfully.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ])
            ->emptyStateActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArchivedModules::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = Filament::auth()->user();

        // Hide from navigation for users with the 'student' or 'parent' role
        if ($user->hasRole('student') || $user->hasRole('parent')) {
            return false;
        }

        // Otherwise, defer to the parent method for other roles
        return parent::canViewAny();
    }

    public static function canViewForNavigation(): bool
    {
        $user = Filament::auth()->user();

        // Hide from navigation for users with the 'student' role
        return ! $user->hasRole('student');
    }
}
