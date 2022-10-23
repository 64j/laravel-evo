<?php

namespace Manager\Traits;

trait PathsTrait
{
    /**
     * Get the path to the application "app" directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function path($path = ''): string
    {
        $appPath = $this->appPath ?: $this->basePath(DIRECTORY_SEPARATOR . $this->getNamespace());

        return $appPath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param string $path
     *
     * @return string
     */
    public function configPath($path = ''): string
    {
        return $this->basePath(
            $this->getNamespace() . DIRECTORY_SEPARATOR . 'config' . ($path ? DIRECTORY_SEPARATOR . $path : $path)
        );
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function resourcePath($path = ''): string
    {
        return $this->basePath(
            $this->getNamespace() . DIRECTORY_SEPARATOR . 'resources' . ($path ? DIRECTORY_SEPARATOR . $path : $path)
        );
    }

    /**
     * @return string
     */
    public function storagePath(): string
    {
        return $this->storagePath
            ?: $this->basePath($this->getNamespace() . DIRECTORY_SEPARATOR . 'storage');
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function viewPath($path = ''): string
    {
        return $this->basePath(
            $this->getNamespace() . DIRECTORY_SEPARATOR . 'views' . ($path ? DIRECTORY_SEPARATOR . $path : $path)
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
