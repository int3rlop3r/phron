<?php namespace Phron\Command;

/**
 * Description of ShowCommand
 *
 * @author jonathan
 */

use Cron\FieldFactory;
use Phron\Processor\JobBuilder;
use Phron\Processor\Entries;
use Phron\Processor\Questions\QuestionFactory;
use Phron\Processor\Questions\Questionable;

class AddCommand extends AbstractCommand
{
    public function __construct(Entries $entries, JobBuilder $jobBuilder, FieldFactory $fieldFactory)
    {
        parent::__construct($entries, $jobBuilder, $fieldFactory);
    }
    
    public function configure()
    {
        $this->setName('add')
             ->setDescription('Create a new task')
             ->setHelp('Create a new task');
    }

    public function fire()
    {
        $itemList = $this->jobBuilder->getFieldList();
        
        // set the name of the cron
        $name = $this->ask('Name of the task: ');
        
        $this->jobBuilder->setName($name);
        
        // generate the expression
        foreach ($itemList as $item => $className)
        {
            $questionClass = QuestionFactory::create($className, $this->fieldFactory);
            
            $question = $questionClass->getQuestion();
            $options  = $questionClass->getOptions();
            
            $selection = $this->askWithOptions($question, $options);
            $userInput = $questionClass->getBySelection($selection);
            
            if (is_null($userInput))
            {
                $userInput = $this->askAndValidate(
                        $questionClass->getCustomValueQuestion(), 
                        $questionClass->getValidator()
                    );
            }
            
            $this->jobBuilder->setFieldValue($item, $userInput);
        }
        
        // set command
        $command =  $this->askAndValidate('Enter Command: ', function($answer)
                    {
                        if (is_null($answer))
                        {
                            throw new \RuntimeException("Invalid value entered");
                        }
                        
                        return $answer;
                    });
        
        $this->jobBuilder->setCommand($command);
        
        // set log file
        $logFile = $this->ask('File to log output: ');
        
        if (trim($logFile) != '')
        {
            $this->jobBuilder->setLogFile($logFile);
        }
        
        // set error log file
        $errorLog = $this->ask('File to log errors: ');
        
        if (trim($errorLog))
        {
            $this->jobBuilder->setErrorFile($errorLog);
        }
        
        if ($this->entries->add($this->jobBuilder->getJob()))
        {
            $this->writeln("New cron added");
        }
        else
        {
            $this->writeln("Failed to add cron");
        }
    }
}
