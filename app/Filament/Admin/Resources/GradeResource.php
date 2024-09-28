<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GradeResource\Pages;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationGroup = 'Teachers';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Student')
                    ->options(User::whereHas('roles', function ($query) {
                        $query->where('name', 'student'); // Assumes Spatie Roles package
                    })->pluck('name', 'id')) // Fetches students only
                    ->searchable() // Adds a search option to the select field
                    ->required(),

                // Section dropdown
                Select::make('section_id')
                    ->label('Section')
                    ->options(Section::all()->pluck('name', 'id')) // Fetches sections
                    ->searchable()
                    ->required(),

                // Subject dropdown
                Select::make('subject_id')
                    ->label('Subject')
                    ->options(Subject::all()->pluck('name', 'id')) // Fetches subjects
                    ->searchable()
                    ->required(),

                TextInput::make('first_quarter')
                    ->numeric()
                    ->label('First Quarter')
                    ,
                TextInput::make('second_quarter')
                    ->numeric()
                    ->label('Second Quarter')
                    ,
                TextInput::make('third_quarter')
                    ->numeric()
                    ->label('Third Quarter')
                    ,
                TextInput::make('fourth_quarter')
                    ->numeric()
                    ->label('Fourth Quarter')
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Student')->sortable(),
                TextColumn::make('subject')->sortable(),
                TextColumn::make('first_quarter')->label('First Quarter'),
                TextColumn::make('second_quarter')->label('Second Quarter'),
                TextColumn::make('third_quarter')->label('Third Quarter'),
                TextColumn::make('fourth_quarter')->label('Fourth Quarter'),
                TextColumn::make('average')
                    ->label('Average Score')
                    ->getStateUsing(fn ($record) => $record->average)
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrade::route('/create'),
            'edit' => Pages\EditGrade::route('/{record}/edit'),
        ];
    }
}