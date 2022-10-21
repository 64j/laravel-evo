<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

class Tree extends Controller
{
    public function get()
    {
        return $this->ok(['Tree get']);
    }
}
