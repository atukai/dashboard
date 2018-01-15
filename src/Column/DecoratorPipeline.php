<?php

namespace Gridly\Column;

use SplQueue;
use function is_callable;

class DecoratorPipeline implements Decorator
{
    /**
     * @var SplQueue
     */
    private $queue;

    public function __construct()
    {
        $this->queue = new SplQueue();
    }

    /**
     * @param callable|CallableDecorator $decorator
     * @return DecoratorPipeline
     */
    public function pipe(callable $decorator): DecoratorPipeline
    {
        if (!$decorator instanceof Decorator && is_callable($decorator)) {
            $decorator = new CallableDecorator($decorator);
        }

        $pipeline = clone $this;
        $pipeline->queue->enqueue($decorator);
        return $pipeline;
    }

    /**
     * @param Column $column
     * @return Column
     */
    public function __invoke(Column $column): Column
    {
        foreach ($this->queue as $decorator) {
            $column = $decorator($column);
        }
        return $column;
    }
}