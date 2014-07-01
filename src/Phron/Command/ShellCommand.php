<?php namespace Phron\Command;

use Symfony\Component\Console\Command\Command;
use Phron\Processor\Scheduler;

//use Symfony\Component\Console\Input\InputArgument;
//use Symfony\Component\Console\Input\InputOption;

class ShellCommand extends Command
{
    use \Phron\Command\Command;
    
    private $scheduler;
    
    public function __construct(Scheduler $scheduler)
    {
        parent::__construct();
        
        $this->scheduler = $scheduler;
    }
    
    protected function configure()
    {
        $this
            ->setName('run:shell')
            ->setDescription('Run an interactive shell');
    }

    protected function fire()
    {
        $stack = $this->scheduler->getStack();
        
        foreach ($stack as $stackItem) {
            
            $question  = $this->scheduler->getQuestion($stackItem);
            
            $userInput = $this->ask($question);
            
            if ($userInput == 'quit') {
                $this->output->writeln('Bye');
                break;
            }
        }
    }
}