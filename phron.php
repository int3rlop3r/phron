#!/usr/bin/env php
<?php
// die(__DIR__.'/vendor/autoloader.php');
require __DIR__.'/vendor/autoload.php';



$app = new Symfony\Component\Console\Application('Phron', '0.1');
$app->add(new Phron\Command\ShellCommand); // add the interactive shell

$app->run();