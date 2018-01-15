<?php

namespace Gridly;

use Gridly\Column\DecoratorPipeline;
use Gridly\Paginator\Paginator;
use Gridly\Schema\Schema;
use Gridly\Source\Source;

class Grid
{
    /** @var Source  */
    private $source;

    /** @var Schema */
    private $schema;
    
    /** @var Paginator  */
    private $paginator;
    
    /** @var array  */
    private $columnDecorators;
    
    /**
     * @param Source $source
     * @param Schema $schema
     * @param Paginator $paginator
     */
    public function __construct(Source $source, Schema $schema, Paginator $paginator)
    {
        $this->source = $source;
        $this->schema = $schema;
        $this->paginator = $paginator;
        $this->columnDecorators = [];
    }
    
    /**
     * @param int|null   $page
     * @param array|null $hiddenColumns
     * @return ResultSet
     */
    public function getPageItems(?int $page = 1, ?array $hiddenColumns = []): ResultSet
    {
        $source = clone $this->source;
        $this->source->applySchema($this->schema);

        $result = (new ResultSet($this->paginator))->fetch($page, $hiddenColumns, $this->columnDecorators);
        $this->source = $source;
        
        return $result;
    }
    
    /**
     * @param string   $columnName
     * @param callable $decorator
     * @return Grid
     */
    public function addColumnDecorator(string $columnName, callable $decorator): self
    {
        if (!isset($this->columnDecorators[$columnName])) {
            $this->columnDecorators[$columnName] = new DecoratorPipeline();
        }

        /** @var DecoratorPipeline $pipeline */
        $pipeline = $this->columnDecorators[$columnName];
        $pipeline->pipe($decorator);

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->paginator->getTotalPages();
    }
    
    /**
     * @return int
     */
    public function getTotalItems(): int
    {
        return $this->source->count();
    }
}
