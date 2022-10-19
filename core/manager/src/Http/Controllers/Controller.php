<?php

namespace Manager\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Manager\Http\Kernel;
use Manager\Interfaces\ControllerInterface;

abstract class Controller extends BaseController implements ControllerInterface
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @var Kernel
     */
    protected Kernel $kernel;

    /**
     * @var string
     */
    protected string $view;

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var array
     */
    protected array $parameters = [];

    /**
     * @var int
     */
    protected int $index;

    /**
     * @param Kernel $kernel
     * @param array $data
     */
    public function __construct(Kernel $kernel, array $data = [])
    {
        $this->kernel = $kernel;
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @param $index
     *
     * @return void
     */
    public function setIndex($index): void
    {
        $this->index = $index;
    }

    /**
     * @param array $params
     *
     * @return string
     */
    public function render(array $params = []): string
    {
        return $this->kernel->view(
            $this->getView(),
            $this->getParameters($params)
        )->with([
            'controller' => $this,
        ])->render();
    }

    /**
     * @return string|null
     */
    public function getView(): ?string
    {
        return $this->view;
    }

    /**
     * @param $view
     *
     * @return bool
     */
    public function setView($view): bool
    {
        if (View::exists($this->kernel->getViewName($view))) {
            $this->view = $view;
        }

        return $view === $this->getView();
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getParameters(array $params = []): array
    {
        return array_merge($this->parameters, $params);
    }

    /**
     * @return bool
     */
    public function canView(): bool
    {
        return true;
    }

    /**
     * @return string|null
     */
    public function checkLocked(): ?string
    {
        return null;
    }

    /**
     * @return bool
     */
    public function process(): bool
    {
        return true;
    }
}
