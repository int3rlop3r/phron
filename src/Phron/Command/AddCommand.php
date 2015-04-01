<?php namespace Phron\Command;

/**
 * Description of ShowCommand
 *
 * @author jonathan
 */

use Phron\Processor\Questions\QuestionFactory;

class AddCommand extends AbstractCommand
{
    public function configure()
    {
        $this->setName('add')
             ->setDescription('Create a new task')
             ->setHelp('Create a new task');
    }
    
    /**
     * Asks for and generate field values.
     * 
     * @return $this
     */
    public function askFieldQuestions()
    {
        $itemList = $this->jobBuilder->getFieldList();
        
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
    }

    public function fire()
    {
        $table = $this->getHelper('table');

        // set the name of the cron
        $name = $this->ask('Name of the task / Comments: ');
        $this->jobBuilder->setComments($name);

        
        // generate the expression
        $this->askFieldQuestions();
        
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

        try
        {
            $job = $this->jobBuilder->make()->getJob();

            // Render the task
            $this->displayTasks($table, array($job));

            if ($this->confirm("Continue with action?"))
            {
                $this->entries->add($job);
                $this->entries->save();
                $this->writeln("New cron added");
            }
            else
            {
                $this->writeln("Operation cancelled.");
            }
        }
        catch (Exception $ex)
        {
            $this->writeln("Failed to add cron");
        }
    }
}
