<?php namespace Phron\Command;

use Symfony\Component\Console\Command\Command;
use Phron\Processor\Scheduler;

/**
 * Class ShellCommand
 * @package Phron\Command
 */
class ShellCommand extends Command
{
    use \Phron\Command\Command;
    
    private $scheduler;


    /**
     * @param Scheduler $scheduler
     */
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

        $this->askQuestions($stack);
    }


    /**
     * @param array $stack
     */
    protected function askQuestions(array $stack)
    {
        foreach ($stack as $stackItem) {

            // fetch question for the stack item
            $question  = $this->scheduler->getQuestion($stackItem);

            // ask a question
            $userInput = $this->ask($question);

            // Process the answer

            // if 'no' prompt for a custom value
            if ((strtolower($userInput) == 'n' || strtolower($userInput) == 'no')
                && $stackItem != 'command')
            {
                $subQuestion = $this->scheduler->getSubQuestion($stackItem);
                $userInput   = $this->ask($subQuestion);
            } elseif ((strtolower($userInput) == 'y' || strtolower($userInput) == 'yes')
                && $stackItem != 'command')
            {
                // if 'yes' set the default value
                $userInput = '*';

            } elseif ($stackItem == 'command' && trim($userInput) == '') {

                do {
                    // prompt the user for a valid input
                    $userInput = $this->ask('Invalid input, please try again: ');

                } while(trim($userInput) == '');
            }

            // save the answer
            $this->scheduler->answerQuestion($stackItem, $userInput);
        }

        // var_dump($this->scheduler->getAnswers());
    }
}