<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ModuleResource\Pages;
use App\Models\Module;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ModuleResource extends Resource
{
    protected static ?string $model = Module::class;

    protected static ?string $navigationGroup = 'Modules';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Check if the user is authenticated
        if (auth()->check()) {
            // Allow user with `user_id` 1 to see all records
            if (auth()->id() === 1) {
                return $query; // No filtering applied for user_id 1
            }

            // For other users, filter records by user_id
            return $query->where('user_id', auth()->id());
        }

        // Fallback for unauthenticated users (shouldn't happen in this context)
        return $query->whereRaw('0 = 1'); // Return no records
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                FileUpload::make('archive')
                    ->disk('public') // Ensure the file is stored on the public disk
                    ->directory('modules') // Save files in the modules directory within the public disk
                    ->downloadable()
                    ->label('Module File')
                    ->previewable(),

                Select::make('section_id')
                    ->label('Assigned Section')
                    ->options(function () {
                        // Retrieve the section assigned to the authenticated user
                        $section = Auth::user()->section;

                        return $section ? [$section->id => $section->name] : [];
                    })
                    ->default(fn () => Auth::user()->section->id ?? null)
                    ->disabled() // Disable to prevent changes if necessary
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Fetch users linked to the selected section
                        $students = User::whereHas('section', function ($query) use ($state) {
                            $query->where('id', $state);
                        })->get();

                        // Get the student names and populate the 'student_names' field
                        $studentNames = $students->pluck('name')->implode(', ');
                        $set('student_names', $studentNames);
                    }),

                TextInput::make('student_names')
                    ->label('Assigned Students')
                    ->disabled()
                    ->reactive(),

                Hidden::make('user_id')
                    ->default(Auth::id()), // Automatically set the user ID
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),

                TextColumn::make('sections')
                    ->label('Sections')
                    ->sortable()
                    ->wrap()
                    ->getStateUsing(function ($record) {
                        // Concatenate the names of all related sections
                        return $record->sections->pluck('name')->join(', ');
                    }),

                // Direct download icon for files on the public disk
                IconColumn::make('archive') // New column for PDF download
                    ->label('Download PDF')
                    ->boolean() // Optional: makes it toggleable
                    ->trueIcon('heroicon-o-document') // Icon for the PDF
                    ->action(fn (Module $record) => Response::download($record->archive) // Adjust the path as necessary
                    )
                    ->color('success'), // Optional: Set color for the icon
            ])
            ->filters([
                // Define any filters if necessary
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
            'index' => Pages\ListModules::route('/'),
            'create' => Pages\CreateModule::route('/create'),
            'edit' => Pages\EditModule::route('/{record}/edit'),
        ];
    }
}
