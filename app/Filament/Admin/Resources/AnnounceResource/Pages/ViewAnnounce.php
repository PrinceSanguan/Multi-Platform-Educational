<?php

namespace App\Filament\Admin\Resources\AnnounceResource\Pages;

use App\Filament\Admin\Resources\AnnounceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAnnounce extends ViewRecord
{
    protected static string $resource = AnnounceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
