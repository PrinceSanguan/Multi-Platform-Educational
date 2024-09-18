<?php

namespace App\Filament\Admin\Pages;

use App\Models\ChatThread;
use Filament\Pages\Page;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.chat';

    public $thread;

    public function mount($threadId)
    {
        $this->thread = ChatThread::with('messages.sender')->findOrFail($threadId);
    }

    protected function getViewData(): array
    {
        return [
            'thread' => $this->thread,
        ];
    }
}
