<?php

declare(strict_types=1);

namespace Manager\Http\Middleware;

use Fruitcake\Cors\HandleCors as Middleware;

class HandleCors extends Middleware
{
    /**
     * Paths by given host or string values in config by default
     *
     * @param string $host
     *
     * @return array
     */
    protected function getPathsByHost(string $host): array
    {
        return ['*'];
    }
}
