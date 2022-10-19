<?php

namespace Manager\Interfaces;

use Manager\Http\Kernel;

interface ControllerInterface
{
    /**
     * @param Kernel $kernel
     * @param array $data
     */
    public function __construct(Kernel $kernel, array $data = []);

    /**
     * @param $index
     *
     * @return void
     */
    public function setIndex($index): void;

    /**
     * @return int
     */
    public function getIndex(): int;

    /**
     * @param array $params
     *
     * @return string
     */
    public function render(array $params = []) : string;

    /**
     * @param array $params
     *
     * @return array
     */
    public function getParameters(array $params = []) : array;

    /**
     * @return string|null
     */
    public function getView() : ?string;

    /**
     * @param string $view
     *
     * @return bool
     */
    public function setView(string $view) : bool;

    /**
     * @return bool
     */
    public function canView() : bool;
}
