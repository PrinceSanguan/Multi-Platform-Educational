<?php

namespace App\Filament\Admin\Resources\AnnounceResource\Pages;

use App\Filament\Admin\Resources\AnnounceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnnounce extends EditRecord
{
    protected static string $resource = AnnounceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
