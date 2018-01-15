<?php

use Gridly\Renderer\SymfonyConsoleCommandRenderer;
use Symfony\Component\Console\Application;

include 'vendor/autoload.php';

// COMMANDS
$listCommand = new SymfonyConsoleCommandRenderer();

// APPLICATION
$application = new Application('Gridly', '0.5.0');
$application->add($listCommand);
$application->setDefaultCommand($listCommand->getName());
$application->run();
