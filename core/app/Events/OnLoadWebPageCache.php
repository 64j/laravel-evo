<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class OnLoadWebPageCache
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct()
    {
        $eventName = trim(str_replace(__NAMESPACE__, '', __CLASS__), '\\');
        app()->evalPlugins(Cache::get('evo.events')[$eventName] ?? '', [...func_get_args()]);
    }
}
