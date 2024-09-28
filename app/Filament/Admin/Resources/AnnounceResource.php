<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AnnounceResource\Pages;
use App\Models\Announce;
use Filament\Forms;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;

class AnnounceResource extends Resource
{
    protected static ?string $model = Announce::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Forms\Components\Section::make('Announcement Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Announcement Title')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('body')
                            ->label('Description')
                            ->required()
                            ->maxLength(255)
                            ->rows(4),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Upload Image')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Announcement Image')
                            ->required()
                            ->image()
                            ->directory('announcements/images')
                            ->imagePreviewHeight('0'), // Hides the default preview

                        // Use the View component to render the custom Blade view for the image preview
                        View::make('components.enlarge-image')->viewData([
                            'record' => fn () => $form->getRecord(),
                        ]),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('body')->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAnnounces::route('/'),
            'create' => Pages\CreateAnnounce::route('/create'),
            'view' => Pages\ViewAnnounce::route('/{record}'),
            'edit' => Pages\EditAnnounce::route('/{record}/edit'),
        ];
    }
}
