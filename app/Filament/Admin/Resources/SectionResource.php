<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SectionResource\Pages;
use App\Models\Section;
use App\Models\User;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationGroup = 'Modules';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Customize the query to filter sections based on the authenticated user.
     */
    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->where('user_id', auth()->id());
    // }
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
                    ->required()
                    ->label('Section Name'),

                BelongsToManyMultiSelect::make('subjects')
                    ->relationship('subjects', 'name')
                    ->label('Subjects')
                    ->required(),

                Select::make('user_id')
                    ->label('Assign User')
                    ->relationship('user', 'name')
                    ->options(User::pluck('name', 'id'))
                    ->required()
                    ->preload(),

                Select::make('students')
                    ->label('Assign Students')
                    ->multiple()
                    ->relationship('students', 'name')
                    ->options(User::role('student')->pluck('name', 'id'))
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

                TextColumn::make('user.name')
                    ->label('Assigned User'),

                TextColumn::make('students.name')
                    ->label('Assigned Students')
                    ->limit(15),
            ])
            // ->modifyQueryUsing(function (Builder $query) {
            //     if (auth()->check() && auth()->user()->role === 'teacher') {
            //         $query->where('user_id', auth()->id());
            //     }
            // })
            ->filters([
                // Tables\Filters\Filter::make('assigned')
                // ->query(function (Builder $query) {
                //     // Apply filter for teachers to only see their assigned sections
                //     if (Auth::check() && Auth::user()->role === 'teacher') {
                //         $query->where('user_id', Auth::id());
                //     }
                // })
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
        return [];
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
