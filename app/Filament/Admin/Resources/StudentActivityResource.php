<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StudentActivityResource\Pages;
use App\Models\StudentActivity;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
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

    protected static ?string $navigationGroup = 'Teachers';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                Textarea::make('description'),
                FileUpload::make('image_path') // Add the image upload field
                    ->label('Activity Image')
                    ->image()
                    ->directory('student-activities')
                    ->required(), // Optionally make it required
                Select::make('status')
                    ->options([
                        'visible' => 'Visible',
                        'hidden' => 'Hidden',
                    ])
                    ->default('visible')
                    ->required(),
                Select::make('section_id')
                    ->label('Section')
                    ->relationship('section', 'name')
                    ->required(),
                Select::make('students')
                    ->label('Assign Students')
                    ->multiple()
                    ->relationship('students', 'name')
                    ->preload()
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search) => User::role('student')->where('name', 'like', "%{$search}%")->pluck('name', 'id'))
                    ->options(User::role('student')->pluck('name', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('section.name') // Display section name
                    ->label('Section')
                    ->sortable(),
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
