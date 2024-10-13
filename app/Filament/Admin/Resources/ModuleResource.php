<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ModuleResource\Pages;
use App\Models\Module;
use App\Models\Section;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Response;

class ModuleResource extends Resource
{
    protected static ?string $model = Module::class;

    protected static ?string $navigationGroup = 'Teachers';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required(),

            FileUpload::make('archive')
                ->downloadable()
                // ->enablePreview() // Uncomment if you want to enable preview
                ->label('Module File'),

            MultiSelect::make('sections')
                ->relationship('sections', 'name') // Load sections
                ->reactive() // Makes the field reactive
                ->afterStateUpdated(function ($state, callable $set) {
                    // When sections are selected, update the student names text input
                    $students = User::whereHas('sections', function($query) use ($state) {
                        $query->whereIn('sections.id', $state); // Get students assigned to selected sections
                    })->get();

                    // Get the names of the students
                    $studentNames = $students->pluck('name')->implode(', ');

                    // Set the student names in the text input
                    $set('student_names', $studentNames);
                })
                ->label('Assign Sections'),

            TextInput::make('student_names')
                ->label('Assigned Students')
                ->disabled() // Disable editing since this is auto-populated
                ->reactive(), // Optional: Make it reactive if you want to trigger updates
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                // TextColumn::make('archive'),
                TextColumn::make('sections.name'), //this will display sections associated with the module
                IconColumn::make('archive') // New column for PDF download
                    ->label('Download PDF')
                    ->boolean() // Optional: makes it toggleable
                     ->trueIcon('heroicon-o-document') // Icon for the PDF
                    ->action(fn (Module $record) =>
                        Response::download($record->archive) // Adjust the path as necessary
                    )
                    ->color('success'), // Optional: Set color for the icon
            ])
            ->filters([

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