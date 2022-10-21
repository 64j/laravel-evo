<?php

namespace Manager\Traits;

use Fruitcake\Cors\CorsServiceProvider;
use Illuminate\Auth\AuthServiceProvider;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Illuminate\Broadcasting\BroadcastServiceProvider;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Cookie\CookieServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Encryption\EncryptionServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Notifications\NotificationServiceProvider;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Pipeline\PipelineServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\View\ViewServiceProvider;
use Manager\Providers\AppServiceProvider;
use Manager\Providers\EventServiceProvider;
use Manager\Providers\RouteServiceProvider;

trait ProvidersTrait
{
    /**
     * @var array
     */
    protected array $providers = [
        /*
         * Laravel Framework Service Providers...
         */
        AuthServiceProvider::class,
        BroadcastServiceProvider::class,
        BusServiceProvider::class,
        CacheServiceProvider::class,
        ConsoleSupportServiceProvider::class,
        CookieServiceProvider::class,
        DatabaseServiceProvider::class,
        EncryptionServiceProvider::class,
        FilesystemServiceProvider::class,
        FoundationServiceProvider::class,
        HashServiceProvider::class,
        MailServiceProvider::class,
        NotificationServiceProvider::class,
        PaginationServiceProvider::class,
        PipelineServiceProvider::class,
        QueueServiceProvider::class,
        RedisServiceProvider::class,
        PasswordResetServiceProvider::class,
        SessionServiceProvider::class,
        TranslationServiceProvider::class,
        ValidationServiceProvider::class,
        ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        CorsServiceProvider::class,
        AppServiceProvider::class,
        \Manager\Providers\AuthServiceProvider::class,
        //\Manager\Providers\BroadcastServiceProvider::class,
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * @return void
     */
    public function registerConfiguredProviders()
    {
        $providers = Collection::make($this->providers)
            ->partition(function ($provider) {
                return strpos($provider, 'Illuminate\\') === 0;
            });

        $providers->splice(1, 0, [$this->make(PackageManifest::class)->providers()]);

        (new ProviderRepository($this, new Filesystem(), $this->getCachedServicesPath()))
            ->load($providers->collapse()->toArray());
    }
}
