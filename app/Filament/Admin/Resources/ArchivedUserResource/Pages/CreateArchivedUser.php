<?php

namespace App\Filament\Admin\Resources\ArchivedUserResource\Pages;

use App\Filament\Admin\Resources\ArchivedUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArchivedUser extends CreateRecord
{
    protected static string $resource = ArchivedUserResource::class;
}
