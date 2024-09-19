<?php

namespace App\Filament\Admin\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Redirect;

class Chat extends Page
{
    use HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    //protected static string $view = 'filament.admin.pages.chat';
    public function mount()
    {
        // Redirect to /chatify
        return Redirect::to('/chatify');
    }
}
