<?php

namespace App\Filament\Admin\Resources\StudentActivityResource\Pages;

use App\Filament\Admin\Resources\StudentActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentActivity extends EditRecord
{
    protected static string $resource = StudentActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
