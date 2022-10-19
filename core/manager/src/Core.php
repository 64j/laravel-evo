<?php

declare(strict_types=1);

namespace Manager;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @property Request $request
 */
class Core extends Application
{
    /**
     * @var array
     */
    protected array $providers = [
        /*
         * Laravel Framework Service Providers...
         */
        \Illuminate\Auth\AuthServiceProvider::class,
        \Illuminate\Broadcasting\BroadcastServiceProvider::class,
        \Illuminate\Bus\BusServiceProvider::class,
        \Illuminate\Cache\CacheServiceProvider::class,
        \Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        \Illuminate\Cookie\CookieServiceProvider::class,
        \Illuminate\Database\DatabaseServiceProvider::class,
        \Illuminate\Encryption\EncryptionServiceProvider::class,
        \Illuminate\Filesystem\FilesystemServiceProvider::class,
        \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        \Illuminate\Hashing\HashServiceProvider::class,
        \Illuminate\Mail\MailServiceProvider::class,
        \Illuminate\Notifications\NotificationServiceProvider::class,
        \Illuminate\Pagination\PaginationServiceProvider::class,
        \Illuminate\Pipeline\PipelineServiceProvider::class,
        \Illuminate\Queue\QueueServiceProvider::class,
        \Illuminate\Redis\RedisServiceProvider::class,
        \Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        \Illuminate\Session\SessionServiceProvider::class,
        \Illuminate\Translation\TranslationServiceProvider::class,
        \Illuminate\Validation\ValidationServiceProvider::class,
        \Illuminate\View\ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        //\Manager\Providers\AppServiceProvider::class,
        //\Manager\Providers\AuthServiceProvider::class,
        //\Manager\Providers\BroadcastServiceProvider::class,
        //\Manager\Providers\EventServiceProvider::class,
        \Manager\Providers\RouteServiceProvider::class,
    ];

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        $providers = Collection::make($this->providers)
            ->partition(function ($provider) {
                return strpos($provider, 'Illuminate\\') === 0;
            });

        $providers->splice(1, 0, [$this->make(PackageManifest::class)->providers()]);

        (new ProviderRepository($this, new Filesystem, $this->getCachedServicesPath()))
            ->load($providers->collapse()->toArray());
    }

    /**
     * Get the path to the resources' directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function resourcePath($path = ''): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'manager' . DIRECTORY_SEPARATOR .
            'resources' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
