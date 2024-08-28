<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StudentActivityResource\Pages;
use App\Models\StudentActivity;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Auth;

class StudentActivityResource extends Resource
{
        protected static ?string $model = StudentActivity::class;
        protected static ?string $navigationGroup = 'Student Management';
        protected static ?string $navigationIcon = 'heroicon-o-folder';
    
        public static function form(Form $form): Form
        {
            return $form
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('description')->nullable(),
                    Select::make('type')
                        ->options([
                            'activity' => 'Activity',
                            'quiz' => 'Quiz',
                            'seatwork' => 'Seatwork',
                        ])
                        ->required(),
                    Select::make('section_id')
                        ->relationship('section', 'name')
                        ->label('Assign to Section')
                        ->nullable(),
                ]);
        }
    
        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    TextColumn::make('name')->label('Name'),
                    TextColumn::make('type')->label('Type'),
                    TextColumn::make('section.name')->label('Section'),
                    TextColumn::make('status')
                        ->label('Visibility')
                        ->formatStateUsing(function ($state) {
                            return $state === 'visible' ? 'Visible' : 'Hidden';
                        }),
                ])
                ->filters([
                    SelectFilter::make('type')
                        ->options([
                            'activity' => 'Activity',
                            'quiz' => 'Quiz',
                            'seatwork' => 'Seatwork',
                        ]),
                ])
                ->actions([
                    Action::make('Toggle Visibility')
                        ->action(function (StudentActivity $record) {
                            $record->toggleVisibility();
                        })
                        ->label(fn (StudentActivity $record) => $record->status === 'hidden' ? 'Unhide' : 'Hide')
                        ->color(fn (StudentActivity $record) => $record->status === 'hidden' ? 'danger' : 'success'),
                ])
                ->bulkActions([
                    BulkActionGroup::make([
                        DeleteBulkAction::make(),
                    ]),
                ]);
        }
    
        public static function getEloquentQuery(): EloquentBuilder
        {
            $user = Auth::user();
    
            if ($user->role_id === 1) {
                return static::getModel()::query();
            }
    
            return static::getModel()::query()->where('user_id', $user->id);
        }
    
        public static function getRelations(): array
        {
            return [];
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