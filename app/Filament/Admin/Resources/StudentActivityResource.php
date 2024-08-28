<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StudentActivityResource\Pages;
use App\Models\StudentActivity;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentActivityResource extends Resource
{
    protected static ?string $model = StudentActivity::class;

    protected static ?string $navigationGroup = 'Modules';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                Textarea::make('description'),
                Select::make('status')
                    ->options([
                        'visible' => 'Visible',
                        'hidden' => 'Hidden',
                    ])
                    ->default('visible')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Action::make('toggleStatus')
                    ->label(fn (StudentActivity $record): string => $record->status === 'visible' ? 'Hide' : 'Unhide')
                    ->icon(fn (StudentActivity $record): string => $record->status === 'visible' ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->action(function (StudentActivity $record) {
                        $record->status = $record->status === 'visible' ? 'hidden' : 'visible';
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color(fn (StudentActivity $record): string => $record->status === 'visible' ? 'danger' : 'success'),
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
            'index' => Pages\ListStudentActivities::route('/'),
            'create' => Pages\CreateStudentActivity::route('/create'),
            'edit' => Pages\EditStudentActivity::route('/{record}/edit'),
        ];
    }
}
