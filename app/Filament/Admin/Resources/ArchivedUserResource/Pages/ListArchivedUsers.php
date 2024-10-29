<?php

namespace App\Filament\Admin\Resources\ArchivedUserResource\Pages;

use App\Filament\Admin\Resources\ArchivedUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArchivedUsers extends ListRecords
{
    protected static string $resource = ArchivedUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
