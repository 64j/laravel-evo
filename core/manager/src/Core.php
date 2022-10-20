<?php

declare(strict_types=1);

namespace Manager;

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
use Illuminate\Foundation\Application;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Http\Request;
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
        Providers\AuthServiceProvider::class,
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

    /**
     * Get the path to the application "app" directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function path($path = ''): string
    {
        $appPath = $this->appPath ?: $this->basePath . DIRECTORY_SEPARATOR . $this->namespace;

        return $appPath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function resourcePath($path = ''): string
    {
        return $this->basePath(
            $this->namespace . DIRECTORY_SEPARATOR . 'resources' . ($path ? DIRECTORY_SEPARATOR . $path : $path)
        );
    }

    /**
     * @return string
     */
    public function storagePath(): string
    {
        return $this->storagePath
            ?: $this->basePath($this->namespace . DIRECTORY_SEPARATOR . 'storage');
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function viewPath($path = ''): string
    {
        return $this->basePath(
            $this->namespace . DIRECTORY_SEPARATOR . 'views' . ($path ? DIRECTORY_SEPARATOR . $path : $path)
        );
    }

    /**
     * @return string
     */
    public function langPath(): string
    {
        return $this->basePath(
            $this->getNamespace() . DIRECTORY_SEPARATOR . 'lang'
        );
    }
}
