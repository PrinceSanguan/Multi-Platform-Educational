<?php

namespace App\Filament\Admin\Resources\MessageResource\Pages;

use App\Events\MessageSent;
use App\Filament\Admin\Resources\MessageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMessage extends CreateRecord
{
    protected static string $resource = MessageResource::class;
    protected function afterCreate(): void
    {
        $message = $this->record;
        broadcast(new MessageSent($message))->toOthers();
    }
}
