#!/usr/bin/env php
<?php
// die(__DIR__.'/vendor/autoloader.php');
require __DIR__.'/vendor/autoload.php';

use Phron\Processor\Scheduler;
use Phron\Command\ShellCommand;
use Symfony\Component\Console\Application;


$scheculer    = new Scheduler;
$shellCommand = new ShellCommand($scheculer);


$app = new Application('Phron', '0.1');
$app->add($shellCommand); // add the interactive shell


$app->run();