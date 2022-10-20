<?php

declare(strict_types=1);

namespace Manager\Http\Middleware;

class HandleCors extends \Fruitcake\Cors\HandleCors
{
    /**
     * Paths by given host or string values in config by default
     *
     * @param string $host
     * @return array
     */
    protected function getPathsByHost(string $host): array
    {
        return ['*'];
    }
}
