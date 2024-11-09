<?php

namespace App\Providers;

use App\Policies\ActivityPolicy;
use App\Policies\FolderPolicy;
use App\Policies\MediaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use TomatoPHP\FilamentMediaManager\Models\Folder;
use TomatoPHP\FilamentMediaManager\Models\Media;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        Gate::policy(Activity::class, ActivityPolicy::class);
        Gate::policy(Media::class, MediaPolicy::class);
        Gate::policy(Folder::class, FolderPolicy::class);
        
          Filament::serving(function () {
            $user = Auth::user();

            if ($user && $user->hasRole('student')) {
                Filament::registerNavigationGroups([
                    NavigationGroup::make('Student Resources'),
                ]);
            } else {
                Filament::registerNavigationGroups([
                    NavigationGroup::make('Teacher Resources'),
                ]);
            }
        });
         Storage::disk('documents')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
        return URL::temporarySignedRoute(
            'private.download',
            $expiration,
            ['path' => $path]
        );
    });
    }
}