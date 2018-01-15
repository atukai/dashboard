<?php

namespace Gridly\Renderer\Cli;

use Gridly\ResultSet;

class TwigRenderer
{
    /**
     * @var
     */
    private $engine;

    /**
     * @var ResultSet
     */
    private $data;

    /**
     * @param ResultSet $data
     */
    public function __construct(ResultSet $data)
    {
        $this->data = $data;
    }
}