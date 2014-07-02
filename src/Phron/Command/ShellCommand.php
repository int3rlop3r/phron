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
            
            if ((strtolower($userInput) == 'n' || strtolower($userInput) == 'no')
                && $stackItem != 'command')
            {
                $subQuestion = $this->scheduler->getSubQuestion($stackItem);
                $userInput   = $this->ask($subQuestion);
            } elseif ((strtolower($userInput) == 'y' || strtolower($userInput) == 'yes')
                && $stackItem != 'command')
            {
                $userInput = '*';
            } elseif ($stackItem == 'command' && trim($userInput) == '') {
                
                do {
                    
                    $userInput = $this->ask('Invalid input, please try again: ');
                    
                } while(trim($userInput) == '');
            }
            
        }
            
        $this->scheduler->answerQuestion($stackItem, $userInput);
    }
}