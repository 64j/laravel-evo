<?php

if (!function_exists('is_cli')) {
    /**
     * @return bool
     */
    function is_cli(): bool
    {
        return php_sapi_name() === 'cli' || php_sapi_name() === 'phpdbg';
    }
}
