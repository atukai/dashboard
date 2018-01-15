<?php

namespace GridlyTest;

use Gridly\Grid;
use Gridly\Paginator\Paginator;
use Gridly\Schema\Schema;
use Gridly\Source\Source;
use PHPUnit\Framework\TestCase;

class ResultSetTest extends TestCase
{
    public function testEmptyResultSetCount(): void
    {
        $grid = $this->createGrid();
        
        $result = $grid->getPageItems();
        self::assertEquals(0, $result->count());
    }
    
    public function testNotEmptyResultSetCount(): void
    {
        $grid = $this->createGridWithData();

        $result = $grid->getPageItems();
        self::assertEquals(2, $result->count());
    }
    
    protected function createGrid(): Grid
    {
        $paginatorMock = $this->createMock(Paginator::class);
        $sourceMock = $this->createMock(Source::class);
        $schemaMock = $this->createMock(Schema::class);
        
        return new Grid($sourceMock, $schemaMock, $paginatorMock);
    }
    
    protected function createGridWithData(): Grid
    {
        $paginatorMock = $this->createMock(Paginator::class);
        $paginatorMock
            ->expects(self::once())
            ->method('getPageItems')
            ->willReturn(
                [
                    [
                        'id' => 1,
                        'name' => 'Aaron Turmonen',
                        'email' => 'aaron@example.com'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Lewis Skorski',
                        'email' => 'lewis@example.com'
                    ]
                ]
            );

        $sourceMock = $this->createMock(Source::class);
        $schemaMock = $this->createMock(Schema::class);

        return new Grid($sourceMock, $schemaMock, $paginatorMock);
    }
}
