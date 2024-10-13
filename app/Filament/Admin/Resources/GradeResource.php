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
use Illuminate\Support\Facades\Auth;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationGroup = 'Teachers';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        // Get the authenticated user
        $user = Auth::user();

        return $form
            ->schema([
                // Select student where the role is 'student'
                Select::make('user_id')
                    ->label('Student')
                    ->options(User::whereHas('roles', function ($query) {
                        $query->where('name', 'student');
                    })->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                // Filter section by teacher (authenticated user)
                Select::make('section_id')
                    ->label('Section')
                    ->options(Section::where('teacher_id', $user->id)->pluck('name', 'id')) // Filter by teacher_id
                    ->searchable()
                    ->required(),

                // Select subject
                Select::make('subject_id')
                    ->label('Subject')
                    ->options(Subject::all()->pluck('name', 'id')) // Assuming you have a subjects table
                    ->searchable()
                    ->required(),

                // Quarter grades
                TextInput::make('first_quarter')
                    ->numeric()
                    ->label('First Quarter'),
                TextInput::make('second_quarter')
                    ->numeric()
                    ->label('Second Quarter'),
                TextInput::make('third_quarter')
                    ->numeric()
                    ->label('Third Quarter'),
                TextInput::make('fourth_quarter')
                    ->numeric()
                    ->label('Fourth Quarter'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Student')->sortable(),
                TextColumn::make('subject.name')->label('Subject')->sortable(),
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