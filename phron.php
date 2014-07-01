#!/usr/bin/env php
<?php
// die(__DIR__.'/vendor/autoloader.php');
require __DIR__.'/vendor/autoload.php';

use Phron\Processor\Scheduler;
use Symfony\Component\Console\Application;
use Phron\Command\ShellCommand;

$scheculer    = new Scheduler;
$shellCommand = new ShellCommand($scheculer);


$app = new Application('Phron', '0.1');
$app->add($shellCommand); // add the interactive shell


$app->run();