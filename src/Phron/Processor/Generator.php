<?php namespace Phron\Processor;

/**
 * Generates and manipulates a cron tab
 *
 * @author jonathan
 */
class Generator
{
    /**
     * @var array Field List '* * * * *'
     */
    private $fields = array(
        'minutes'    => '*',
        'hour'       => '*',
        'dayofmonth' => '*',
        'month'      => '*',
        'dayofweek'  => '*',
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
        
        return $this->fields[$item];
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
        
        $this->fields[$item] = $value;
        
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
        $this->command = $command;
        
        return $this;
    }
    
    /**
     * Get the command to be run
     * 
     * @return string Command to run
     */
    public function getCommand()
    {
        return $this->command;
    }
    
    /**
     * Sets the log file path
     * 
     * @param string $logFile Path to the log file
     * @return $this
     */
    public function setLogFile($logFile)
    {
        $this->logFile = $logFile;
        
        return $this;
    }
    
    /**
     * Gets the log file path
     * 
     * @return string Log file path
     */
    public function getLogfile()
    {
        return $this->logFile;
    }
    
    /**
     * Sets the error log file path
     * 
     * @param string $path Path to the error log file
     * @return $this
     */
    public function setErrorFile($path)
    {
        $this->errorFile = $path;
        
        return $this;
    }
    
    /**
     * Gets the error log file path
     * 
     * @return string Path to the error log file
     */
    public function getErrorFile()
    {
        return $this->errorFile;
    }
    
    /**
     * Sets the comment / description
     * 
     * @param string $comment Comment / description of the crontab
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        
        return $this;
    }
    
    /**
     * Get the cron comment / description
     * 
     * @return string crontab comment / description
     */
    public function getComment()
    {
        return $this->comment;
    }
}
