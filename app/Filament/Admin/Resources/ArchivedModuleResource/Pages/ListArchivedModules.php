<?php

namespace App\Filament\Admin\Resources\ArchivedModuleResource\Pages;

use App\Filament\Admin\Resources\ArchivedModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArchivedModules extends ListRecords
{
    protected static string $resource = ArchivedModuleResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

}