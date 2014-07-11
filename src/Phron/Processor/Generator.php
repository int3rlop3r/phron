<?php namespace Phron\Processor;

/**
 * Generates and manipulates a cron tab
 *
 * @author jonathan
 */

use Crontab\Job;

class Generator
{
    /**
     * @var array Field List mapped to function names of the Job class
     */
    private $fields = array(
        'minutes'    => 'Minute',
        'hour'       => 'Hour',
        'dayofmonth' => 'DayOfMonth',
        'month'      => 'Month',
        'dayofweek'  => 'DayOfWeek',
    );
    
    /**
     * @var string Command to be executed
     */
    private $command;
    
    /**
     * @var string Path of the log file
     */
    private $logFile;
    
    /**
     * @var string Path of the error log file
     */
    private $errorFile;
    
    /**
     * @var string Comment / description about the cron
     */
    private $comment;
    
    /**
     * @var Job Job object
     */
    private $job;
    
    /**
     * @param Job $job Job object
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }
    
    /**
     * Checks if the field name was valid
     * 
     * @param string $item Cron expression field
     * @throws Exception
     * @return bool True if valid
     */
    private function validField($item)
    {
        if (!isset($this->fields[$item])) {
            throw new \Exception("Invalid field: $item.");
        }
        
        return true;
    }
    
    /**
     * Returns the field list
     * 
     * @return array Field list
     */
    public function getFieldList()
    {
        return $this->fields;
    }
    
    /**
     * Gets the value of a field
     * 
     * @param string $item Cron expression field
     * @return string Value of the field
     */
    public function getFieldValue($item)
    {
        $this->validField($item);
        
        $function = 'get' . $this->fields[$item]; // = $value;
        
        return $this->job->$function();
    }
    
    /**
     * Set the value of a field
     * 
     * @param string $item Cron Expression Field
     * @param string $value Value of the field
     * @return $this
     */
    public function setFieldValue($item, $value)
    {
        $this->validField($item);
        
        $function = 'set' . $this->fields[$item]; // = $value;
        
        $this->job->$function($value);
        
        return $this;
    }
    
    /**
     * Sets the command to be run
     * 
     * @param string $command Command to be executed
     * @return $this
     */
    public function setCommand($command)
    {
        $this->job->setCommand($command);
        
        return $this;
    }
    
    /**
     * Get the command to be run
     * 
     * @return string Command to run
     */
    public function getCommand()
    {
        return $this->job->getCommand();
    }
    
    /**
     * Sets the log file path
     * 
     * @param string $logFile Path to the log file
     * @return $this
     */
    public function setLogFile($logFile)
    {
        $this->job->setLogFile($logFile);
        
        return $this;
    }
    
    /**
     * Gets the log file path
     * 
     * @return string Log file path
     */
    public function getLogfile()
    {
        return $this->job->getLogFile();
    }
    
    /**
     * Sets the error log file path
     * 
     * @param string $path Path to the error log file
     * @return $this
     */
    public function setErrorFile($path)
    {
        $this->job->setErrorFile($path);
        
        return $this;
    }
    
    /**
     * Gets the error log file path
     * 
     * @return string Path to the error log file
     */
    public function getErrorFile()
    {
        return $this->job->getErrorFile();
    }
    
    /**
     * Sets the name for the cron
     * 
     * @param string $comments Comment / description of the crontab
     * @return $this
     */
    public function setName($name = 'no name')
    {
        $this->job->setComments($name);
        
        return $this;
    }
    
    /**
     * Gets the name of a cron
     * 
     * @return string crontab comment / description
     */
    public function getName()
    {
        return $this->job->getComments();
    }
    
    /**
     * Returns the job instance
     * 
     * @return Job Job instance
     */
    public function getJob()
    {
        return $this->job;
    }
}