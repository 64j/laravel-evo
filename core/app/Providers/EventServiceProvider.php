<?php

namespace App\Providers;

use App\Models\SystemEventname;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            Cache::rememberForever(
                'evo.events',
                function () {
                    $events = SystemEventname::query()
                        ->with('plugins')
                        ->get();

                    $events->map(
                        fn($event) => $event->plugins->map(
                            fn($plugin) => $this->listen[$event->name][] = $plugin->name
                        )
                    );

                    return $events->keyBy('name')->toArray();
                }
            );
        }
    }
}
