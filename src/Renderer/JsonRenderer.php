<?php

namespace Gridly\Renderer;

use Gridly\Grid;
use JsonException;

class JsonRenderer
{
    /** @var Grid */
    private $grid;
    
    /**
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }
    
    /**
     * @return string
     * @throws JsonException
     */
    public function render(): string
    {
        $page = 1;
        return json_encode($this->grid->getPageItems($page), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }
}
