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
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StudentActivityResource extends Resource
{
    protected static ?string $model = StudentActivity::class;

    protected static ?string $navigationGroup = 'Modules';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->where('user_id', auth()->id());
    // }
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasRole('super_admin') || $user->hasRole('teacher')) {

                return $query;
            } elseif ($user->hasRole('student')) {

                return $query->whereHas('students', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }
        }

        // Fallback for unauthenticated users (no records should be visible)
        return $query->whereRaw('0 = 1');
    }

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
                    ->disk('public')                   // Ensure the file is stored on the public disk
                    ->directory('activity')            // Save files in the 'activity' directory within the public disk
                    ->preserveFilenames()              // Preserve original filenames if needed
                    ->downloadable()                   // Make the file downloadable
                    ->label('Activity File')
                    ->previewable()                    // Show a preview
                    ->visibility('public')             // Set visibility to public
                    ->afterStateUpdated(function ($state) {
                        Log::info('Uploaded file path: '.$state); // Log the file path for debugging
                    }),
                Select::make('status')
                    ->options([
                        'visible' => 'Visible',
                        'hidden' => 'Hidden',
                    ])
                    ->default('visible')
                    ->required(),
                Select::make('section_id')
                    ->label('Assigned Section')
                    ->options(function () {
                        // Retrieve the assigned section for the authenticated user
                        $section = Auth::user()->section;

                        return $section ? [$section->id => $section->name] : [];
                    })
                    ->default(fn () => Auth::user()->section->id ?? null)
                    ->disabled() // Disable the field to prevent changes
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Get students linked to the selected section
                        $students = User::whereHas('section', function ($query) use ($state) {
                            $query->where('id', $state);
                        })->get();

                        // Concatenate the names of all students in the section
                        $studentNames = $students->pluck('name')->implode(', ');
                        $set('student_names', $studentNames);
                    }),
                Select::make('students')
                    ->label('Assign Students')
                    ->multiple() // Allow selecting multiple students
                    ->preload()
                    ->searchable()
                    ->relationship('students', 'name') // Link to the students relationship in StudentActivity
                    ->options(function () {
                        // Filter users by the 'student' role
                        return User::role('student')->pluck('name', 'id');
                    })
                    ->getSearchResultsUsing(fn (string $search) => User::role('student')
                        ->where('name', 'like', "%{$search}%")
                        ->pluck('name', 'id'))
                    ->saveRelationshipsUsing(function ($record, $state) {
                        // Attach the selected students to the activity
                        $record->students()->sync($state);
                    }),
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
                        $filePath = $record->image_path;

                        if (! $filePath) {
                            Notification::make()
                                ->title('File not found')
                                ->danger()
                                ->body('No file is associated with this record.')
                                ->send();

                            return;
                        }

                        if (Storage::disk('public')->exists($filePath)) {
                            return Storage::disk('public')->download($filePath);
                        } else {
                            Notification::make()
                                ->title('File not found')
                                ->danger()
                                ->body('The requested file does not exist.')
                                ->send();
                        }
                    }),
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
                            ->body('The activity has been '.($record->status === 'visible' ? 'made visible' : 'hidden').'.')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color(fn (StudentActivity $record): string => $record->status === 'visible' ? 'danger' : 'success')
                    ->visible(fn () => auth()->user()->hasAnyRole(['admin', 'super_admin', 'teacher'])),
            ]);
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
