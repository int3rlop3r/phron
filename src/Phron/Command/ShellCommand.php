<?php namespace Phron\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ShellCommand extends Command
{
    use \Phron\Command\Command;
    

    
    protected function configure()
    {
        $this
            ->setName('run:shell')
            ->setDescription('Run an interactive shell');
    }

    protected function fire()
    {
        while(($userInput = $this->ask('>')) != 'quit') {
            
        }

        $this->output->writeln("Bye");
    }
}