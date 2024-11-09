<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StudentActivityResource\Pages;
use App\Models\StudentActivity;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Response;

class StudentActivityResource extends Resource
{
    protected static ?string $model = StudentActivity::class;

     protected static ?string $navigationGroup = 'Modules';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Activity Name'),
                Textarea::make('description')
                    ->label('Description'),
                FileUpload::make('image_path')
                    ->label('Activity Image')
                    ->image()
                    ->directory('student-activities')
                    ->required(),
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
                    ->preload()
                    ->searchable()
                    ->options(User::role('student')->pluck('name', 'id'))
                    ->getSearchResultsUsing(fn (string $search) => User::role('student')
                        ->where('name', 'like', "%{$search}%")
                        ->pluck('name', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('section.name')
                    ->label('Section')
                    ->sortable(),
                TextColumn::make('created_at')->dateTime(),
                 IconColumn::make('image_path')
    ->label('Activity Image')
    ->icon('heroicon-o-document')
    ->color('success')
    ->tooltip('Click to download')
    ->action(function (StudentActivity $record) {
        // Retrieve the full URL to the file
        $filePath = $record->image_path; // Assuming `image_path` contains `student-activities/filename.jpg`
        
        // Check if file exists
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath);
        } else {
            Notification::make()
                ->title('File not found')
                ->danger()
                ->body("The requested file does not exist.")
                ->send();
        }
    })
            ])
           ->actions([
   Action::make('toggleStatus')
        ->label(fn (StudentActivity $record): string => $record->status === 'visible' ? 'Hide' : 'Unhide')
        ->icon(fn (StudentActivity $record): string => $record->status === 'visible' ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
        ->action(function (StudentActivity $record) {
            $record->status = $record->status === 'visible' ? 'hidden' : 'visible';
            $record->save();

            Notification::make()
                ->title('Status Updated')
                ->success()
                ->body("The activity has been " . ($record->status === 'visible' ? 'made visible' : 'hidden') . ".")
                ->send();
        })
        ->requiresConfirmation()
        ->color(fn (StudentActivity $record): string => $record->status === 'visible' ? 'danger' : 'success')
      ->visible(fn () => auth()->user()->hasAnyRole(['admin','super_admin','teacher'])), // Hide action if user has "student" role
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
            //   'view' => Pages\View::route('/{record}'),
            'edit' => Pages\EditStudentActivity::route('/{record}/edit'),
        ];
    }
}