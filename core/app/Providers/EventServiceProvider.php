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
        $events = Cache::rememberForever(
            'evo.events',
            fn() => SystemEventname::query()
                ->with('plugins')
                ->get()
                ->keyBy('name')
                ->toArray()
        );

        foreach ($events as $event) {
            foreach ($event['plugins'] as $plugin) {
                if (empty($plugin['disabled'])) {
                    $this->listen[$event['name']][] = $plugin['name'];
                }
            }
        }
    }
}
