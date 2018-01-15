<?php

namespace Gridly;

use Gridly\Paginator\Factory\LaminasPaginatorWrapperFactory;
use Gridly\Source\Filter\Filter;
use Gridly\Source\Order\Order;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

class Factory
{
    /**
     * @param string $fileName
     * @return Grid
     * @throws Source\Exception
     */
    public static function create(string $fileName): Grid
    {
        // CONFIG
        $fileLocator = new FileLocator(['.']);
        $config = Yaml::parse(file_get_contents($fileLocator->locate($fileName)));

        // SOURCE
        $source = Source\Factory::create($config['source']);

        // PAGINATOR
        $paginator = LaminasPaginatorWrapperFactory::create($source, $config['paginator']);

       // SCHEMA
        $schema = new Schema\Schema(
            new Order('server_feature_id', Order::DIRECTION_DESC),
            [new Filter('server_feature_id', Filter::OP_LESS, 5000)]
        );

        // GRID
        $grid = new Grid($source, $schema, $paginator);

        // COLUMN DECORATORS
        /*$grid->addColumnDecorator('city_id', static function (Column $column) {
            return new Column($column->name(), 'City:' . $column->value());
        });
        $grid->addColumnDecorator('opening_rule', static function (Column $column) {
            return new Column($column->name(), strtoupper($column->value()));
        });*/
    
        return $grid;
    }
}
