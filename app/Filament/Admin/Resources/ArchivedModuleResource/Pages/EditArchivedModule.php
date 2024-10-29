<?php

namespace App\Filament\Admin\Resources\ArchivedModuleResource\Pages;

use App\Filament\Admin\Resources\ArchivedModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArchivedModule extends EditRecord
{
    protected static string $resource = ArchivedModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
