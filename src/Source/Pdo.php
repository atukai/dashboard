<?php

namespace Gridly\Source;

use Gridly\Schema;
use Gridly\Source\Filter\Exception;
use Gridly\Source\Filter\Filter;
use PDOStatement;

class Pdo implements Source
{
    /** @var \PDO  */
    private $pdo;

    /** @var string  */
    private $tableName;

    /** @var string  */
    private $query;

    /** @var array  */
    private $queryParams;
    
    /**
     * @param \PDO $pdo
     * @param string $tableName
     */
    public function __construct(\PDO $pdo, string $tableName)
    {
        $this->pdo = $pdo;
        $this->tableName = '`' . str_replace('`', '``', $tableName) . '`';
        $this->query = 'SELECT * FROM ' . $this->tableName;
        $this->queryParams = [];
    }
    
    public function applySchema(Schema\Schema $schema): void
    {
        $this->filter($schema->getFilters());
        
        $order = $schema->getOrder();
        $this->sort($order->getColumnName(), $order->getDirection());
    }
    
    /**
     * @param Filter[] $filters
     * @return Source
     * @throws Exception
     */
    public function filter(iterable $filters = []): Source
    {
        if (empty($filters)) {
            return $this;
        }

        $this->query .= ' WHERE ';

        $filtersAmount = count($filters);
        $lastFilterIndex = $filtersAmount - 1;

        /** @var Filter $filter */
        foreach ($filters as $i => $filter) {
            switch ($filter->getOperand()) {
                case Filter::OP_EQUAL:
                    $this->query .= $filter->getColumnName() . ' = ?';
                    $this->queryParams[] = $filter->getValue();
                    break;
                    
                case Filter::OP_LESS:
                    $this->query .= $filter->getColumnName() . ' < ?';
                    $this->queryParams[] = $filter->getValue();
                    break;
                    
                case Filter::OP_LIKE:
                    $this->query .= $filter->getColumnName() . ' LIKE ?';
                    $this->queryParams[] = '%' . $filter->getValue() . '%';
                    break;
                    
                default:
                    Exception::onUnsupportedFilterOperand($filter->getOperand(), self::class);
            }

            if ($filtersAmount > 1 && $i !== $lastFilterIndex) {
                $this->query .= ' AND ';
            }
        }
        
        return $this;
    }

    public function sort(string $columnName, string $direction): Source
    {
        return $this;
    }

    public function getItems(int $offset, int $limit): iterable
    {
        $query = $this->query;
        
        $limitStatement = ' LIMIT ';
        $limitStatement .= $offset . ', ' . $limit;

        $query .= $limitStatement;

        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($this->queryParams);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $query = 'SELECT COUNT(*) FROM ' . $this->tableName;
        return $this->pdo->query($query)->fetchColumn();
    }
}
