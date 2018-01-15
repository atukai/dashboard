<?php

namespace Gridly;

use ArrayIterator;
use Countable;
use Gridly\Column\Column;
use Gridly\Column\Decorator;
use Gridly\Paginator\Paginator;
use Iterator;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

use function in_array;

class ResultSet implements Countable, IteratorAggregate, JsonSerializable
{
    /** @var Paginator */
    private $paginator;
    
    /** @var array */
    private $headers;
    
    /** @var array */
    private $rows;
    
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
        $this->headers = [];
        $this->rows = [];
    }

    public function fetch(int $page, array $hiddenColumns = [], array $columnDecorators = []): ResultSet
    {
        $data = $this->paginator->getPageItems($page);
        $this->processData($data, $hiddenColumns, $columnDecorators);

        return $this;
    }
    
    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->rows);
    }

    /**
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->rows);
    }

    private function processData(iterable $data, array $hiddenColumns = [], array $columnDecorators = []): void
    {
        if ($data instanceof Iterator && !$data->current()) {
            return;
        }
        
        foreach ($data as $i => $entry) {
            $row = [];
            foreach ($entry as $name => $value) {
                if (in_array($name, $hiddenColumns, true)) {
                    continue;
                }
                
                if ($i === 0) {
                    $this->headers[] = $name;
                }

                $column = new Column($name, $value);
                if (isset($columnDecorators[$column->name()])) {
                    /** @var Decorator $decorator */
                    $decorator = $columnDecorators[$column->name()];
                    $column = $decorator($column);
                }

                $row[$name] = $column;
            }

            $this->rows[] = $row;
        }
    }
    
    public function jsonSerialize(): array
    {
        $data = [];
        foreach ($this->rows as $row) {
            $rowData = [];
            /** @var Column $column */
            foreach ($row as $column) {
                $rowData[$column->name()] = $column->value();
            }
            $data[] = $rowData;
        }
        
        return $data;
    }
}
