<?php

namespace App\Filament\Admin\Resources\StudentActivityResource\Pages;

use App\Filament\Admin\Resources\StudentActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentActivities extends ListRecords
{
    protected static string $resource = StudentActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
