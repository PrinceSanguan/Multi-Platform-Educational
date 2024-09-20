<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SectionResource\Pages;
use App\Models\Section;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Section Name'),

                // Assign Teachers
                Select::make('teachers')
                    ->label('Assign Teachers')
                    ->multiple()
                    ->relationship('teachers', 'name') // Use the relationship method for teachers
                    ->options(User::role('teacher')->pluck('name', 'id')) // Only show users with 'teacher' role
                    ->preload(),

                // Assign Students
                Select::make('students')
                    ->label('Assign Students')
                    ->multiple()
                    ->relationship('students', 'name') // Use the relationship method for students
                    ->options(User::role('student')->pluck('name', 'id')) // Only show users with 'student' role
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->label('Section Name'),

                TextColumn::make('teachers.name')
                    ->label('Assigned Teachers')
                    ->limit(3), // Display up to 3 teachers' names

                TextColumn::make('students.name')
                    ->label('Assigned Students')
                    ->limit(3), // Display up to 3 students' names
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
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
