<?php namespace Phron\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ShellCommand extends Command
{
    use \Phron\Command\Command;
    
    private $questions = array(
            'minutes' => '*',
            * &selectMinutes%5B%5D=0
            * &hours=select
            * &selectHours%5B%5D=0
            * &days=*
            * &months=*
            * &weekdays=*
            * &command=vdfvd
            * &output=1
            * &filePath=
            * &outputEmail=
            * &Generate=Generate+Crontab+Line
    );
    
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