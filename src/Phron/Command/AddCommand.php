<?php namespace Phron\Command;

use Phron\Processor\Entries;
use Symfony\Component\Console\Command\Command;

/**
 * Class AddCommand
 * @package Phron\Command
 */
class AddCommand extends Command
{
    use \Phron\Command\Command;
    
    private $entries;
    
    /**
     * Questions to get the cron expression
     */
    private $questions  = array(
        'minutes'    => 'Enter Minutes [0-59]: ',
        'hour'       => 'Enter Hours [0-23]: ',
        'dayofmonth' => 'Enter Days [1-31]: ',
        'month'      => 'Enter Months [1-12]: ',
        'dayofweek'  => 'Enter Day of the week [0-7]: ',
    );
    
    /**
     * @param Entries $entries
     */
    public function __construct(Entries $entries)
    {
        parent::__construct();
        
        $this->entries   = $entries;
    }

    protected function configure()
    {
        $this
            ->setName('add')
            ->setDescription('Create a new task')
            ->setHelp('Creates a new task')
            ;
    }

    protected function fire()
    {
        $generator = $this->entries->getGenerator();
        
        // generate the expression
        foreach ($this->questions as $item => $question) {
            $userInput = $this->ask($question);
            
            $generator->setFieldValue($item, $userInput);
        }
        
        /**
         * Set the command to run
         */
        do {
            
            $command = $this->ask('Enter Command: ');
        } while ($command === true);
        
        $generator->setCommand($command);
        
        
        $logFile = $this->ask('File to log output: ');
        
        if (trim($logFile) != '') {
            
            $generator->setLogFile($logFile);
        }
        
        $errorLog = $this->ask('File to log errors: ');
        
        if (trim($errorLog)) {
            
            $generator->setErrorFile($errorLog);
        }
        
        // render the cron
        // var_dump($generator->getJob()->render());
    }
}