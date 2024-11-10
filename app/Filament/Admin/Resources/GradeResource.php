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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationGroup = 'Teachers';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Define the query to filter records based on user role.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->hasRole('admin') || $user->hasRole('super_admin')) {
            // Admins and super admins see all grades
            return $query;
        } elseif ($user->hasRole('teacher')) {
            // Teachers only see grades for students in their sections and subjects
            return $query->whereHas('section', function ($q) use ($user) {
                $q->where('user_id', $user->id); // Assuming `user_id` on section is the teacher's ID
            });
        } elseif ($user->hasRole('student')) {
            // Students only see their own grades
            return $query->where('user_id', $user->id);
        }

        // Fallback for unauthenticated users (no records should be visible)
        return $query->whereRaw('0 = 1');
    }

    public static function form(Form $form): Form
    {
        $user = Auth::user();

        return $form
            ->schema([
                // Select student (filtered to only show students if teacher is assigning a grade)
                Select::make('user_id')
                    ->label('Student')
                    ->options(User::whereHas('roles', function ($query) {
                        $query->where('name', 'student');
                    })->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->default($user->id)
                    ->disabled($user->hasRole('student')), // Disable for students to prevent selection

                // Filter sections by the authenticated user's sections if they are a teacher
                Select::make('section_id')
                    ->label('Section')
                    ->options(
                        Section::when($user->hasRole('teacher'), function ($query) use ($user) {
                            return $query->where('user_id', $user->id); // Filter sections by the teacher's user_id
                        })->pluck('name', 'id')
                    )
                    ->searchable()
                    ->required(),

                // Filter subjects by the authenticated user's subjects if they are a teacher
                Select::make('subject_id')
                    ->label('Subject')
                    ->options(
                        Subject::pluck('name', 'id') // Retrieve all subjects without any filtering
                    )
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
                TextColumn::make('student.name') // Display the student's name
                    ->label('Student')
                    ->sortable(),
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
