<?php

declare(strict_types=1);

namespace Manager\Http\Controllers;

use Illuminate\Contracts\View\View as ContractView;

class Home extends Controller
{
    /**
     * @return ContractView
     */
    public function index(): ContractView
    {
        return $this->view('template.default', []);
    }
}
