<?php namespace Phron\Command;

use Cron\FieldFactory;
use Phron\Processor\Generator;
use Phron\Processor\Entries;
use Symfony\Component\Console\Command\Command;
use Phron\Processor\Questions\QuestionFactory;
use Phron\Processor\Questions\Questionable;

/**
 * Class AddCommand
 * @package Phron\Command
 */
class AddCommand extends Command
{
    use \Phron\Command\Command;
    
    /**
     * @var Entries
     */
    private $entries;
    
    /**
     * @var FieldFactory
     */
    private $fieldFactory;
    
    /**
     * @var Generator
     */
    private $generator;
    
    /**
     * @param Entries $entries
     * @param Generator $generator
     * @param FieldFactory $fieldFactory
     */
    public function __construct(Entries $entries, Generator $generator, FieldFactory $fieldFactory)
    {
        parent::__construct();
        
        $this->entries      = $entries;
        $this->generator    = $generator;
        $this->fieldFactory = $fieldFactory;
    }

    protected function configure()
    {
        $this->setName('add')
             ->setDescription('Create a new task')
             ->setHelp('Creates a new task');
    }

    protected function fire()
    {
        $itemList = $this->generator->getFieldList();
        
        // set the name of the cron
        $name = $this->ask('Name of the task: ');
        
        $this->generator->setName($name);
        
        // generate the expression
        foreach ($itemList as $item => $className) {
            
            $questionClass = QuestionFactory::create($className, $this->fieldFactory);
            
            $question = $questionClass->getQuestion();
            $options  = $questionClass->getOptions();
            
            $selection = $this->askWithOptions($question, $options);
            $userInput = $questionClass->getBySelection($selection);
            
            if (is_null($userInput)) {
                
                $userInput = $this->askAndValidate(
                        $questionClass->getCustomValueQuestion(), 
                        $questionClass->getValidator()
                    );
            }
            
            $this->generator->setFieldValue($item, $userInput);
        }
        
        // set command
        $command =  $this->askAndValidate('Enter Command: ', function($answer) {
                        if (is_null($answer)) {
                            throw new \RuntimeException("Invalid value entered");
                        }
                        
                        return $answer;
                    });
        
        $this->generator->setCommand($command);
        
        // set log file
        $logFile = $this->ask('File to log output: ');
        
        if (trim($logFile) != '') {
            
            $this->generator->setLogFile($logFile);
        }
        
        // set error log file
        $errorLog = $this->ask('File to log errors: ');
        
        if (trim($errorLog)) {
            
            $this->generator->setErrorFile($errorLog);
        }
        
        if ($this->entries->add($this->generator->getJob())) {
            
            $this->writeln("New cron added");
        } else {
            
            $this->writeln("Failed to add cron");
        }
    }
}