<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

class Settings extends Controller
{
    public function get()
    {
        return $this->ok(['Settings get']);
    }
}
