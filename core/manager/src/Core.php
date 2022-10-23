<?php

declare(strict_types=1);

namespace Manager;

use App\Models\SystemSetting;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Manager\Events\OnLoadSettings;

/**
 * @property Request $request
 */
class Core extends Application
{
    /**
     * @var string
     */
    protected $namespace = 'manager';

    /**
     * @var string
     */
    protected string $routeNamespace = 'Manager\\Http\\Controllers';

    /**
     * @var array
     */
    public array $config = [];

    /**
     * @return string
     */
    public function getRouteNamespace(): string
    {
        return $this->routeNamespace;
    }

    /**
     * Get the path to the environment file directory.
     *
     * @return string
     */
    public function environmentPath(): string
    {
        return $this->environmentPath ?: dirname($this->basePath);
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        $this->config = Cache::rememberForever('evo.settings', function () {
            $config = SystemSetting::query()
                ->pluck('setting_value', 'setting_name')
                ->toArray();

            OnLoadSettings::dispatch($config);

            return $config;
        });

        return $this->config;
    }

    /**
     * @param $event
     * @param array $params
     *
     * @return void
     */
    public function evalPlugins($event, array $params)
    {
        if (is_null($event)) {
            return;
        }

        extract($params);

        foreach ($event['plugins'] as $plugin) {
            $properties = array_map(
                fn($property) => current($property)['value'] ?? null,
                json_decode($plugin['properties'], true)
            );
            extract($properties);
            eval($plugin['plugincode']);
        }
    }
}
