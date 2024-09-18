<?php

namespace App\Providers;

use App\Models\ChatThread;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    

        // Register custom navigation item
        Filament::registerNavigationItems([
            NavigationItem::make('Chat')
                ->url(function () {
                    // Fetch the thread for the logged-in user
                    $user = Auth::user();
                    
                    // Example logic: Find the first chat thread where the user is involved (you can modify this logic)
                    $thread = ChatThread::where('student_id', $user->id)
                        ->orWhere('teacher_id', $user->id)
                        ->orWhere('admin_id', $user->id)
                        ->first();

                    // Check if a thread exists
                    if ($thread) {
                        // Return the route to the thread
                        return route('chat.list', ['thread' => $thread->id]);
                    }

                    // If no thread exists, redirect to a default page or show an error
                    return '#'; // Replace '#' with a default route if needed
                })
                ->icon('heroicon-o-user') // Use an available icon
                ->sort(1),
        ]);
    }
}
