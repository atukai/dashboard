<?php

namespace Gridly\Renderer;

use Gridly\Column\Column;
use Gridly\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SymfonyConsoleCommandRenderer extends Command
{
    protected static $defaultName = 'list';
    
    public function configure(): void
    {
        $this->setDescription('List of entries.')
            ->setHelp('Print a list of entries')
            ->addOption('schema', 's', InputOption::VALUE_REQUIRED, 'Grid schema file.')
            ->addOption('page', 'p', InputOption::VALUE_REQUIRED, 'Page to display.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $schemaFile = 'gridly.yml';
        if ($input->getOption('schema')) {
            $schemaFile = $input->getOption('schema');
        }
        
        $grid = Factory::create($schemaFile);
        
        $page = 1;
        if ($input->getOption('page')) {
            $page = $input->getOption('page');
        }
        
        $data = $grid->getPageItems($page, ['step_number']);
    
        $table = new Table($output);
        $table->setHeaders($data->getHeaders());

        foreach ($data as $row) {
            $rowData = [];
            /** @var Column $column */
            foreach ($row as $column) {
                $rowData[] = $column->value();
            }
            $table->addRow($rowData);
        }
    
        $table->setHeaderTitle(sprintf('Entries: %d/%d', count($data), $grid->getTotalItems()));
        $table->setFooterTitle(sprintf('Page: %d/%d', $page, $grid->getTotalPages()));
        $table->render();
        
        return Command::SUCCESS;
    }
}
