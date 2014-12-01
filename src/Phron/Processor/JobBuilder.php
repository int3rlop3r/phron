<?php namespace Phron\Processor;

/**
 * JobBuilder
 * 
 * @author jonathan
 */
use Crontab\Job;

class JobBuilder
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
     * @var array
     */
    private $jobContainer;

    /**
     * @var Job Job object
     */
    private $job;

    /**
     * Checks if the field name was valid
     * 
     * @param string $item Cron expression field
     * @throws Exception
     * @return bool True if valid
     */
    private function validField($item)
    {
        if (!isset($this->fields[$item]))
        {
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
    public function getFieldValueTest($item)
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
    public function setFieldValueTest($item, $value)
    {
        $this->validField($item);

        $function = 'set' . $this->fields[$item]; // = $value;

        $this->job->$function($value);

        return $this;
    }

    /**
     * Gets the value of a field
     * 
     * @param string $item Cron expression field
     * @return string
     */
    public function getFieldValue($item)
    {
        $this->validField($item);

        if (!isset($this->jobContainer[$this->fields[$item]]))
        {
            return null;
        }

        return $this->jobContainer[$this->fields[$item]];
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

        $key = $this->fields[$item];

        $this->jobContainer[$key] = $value;

        return $this;
    }


        /*
         *'minutes'    => 'Minute',
         *'hour'       => 'Hour',
         *'dayofmonth' => 'DayOfMonth',
         *'month'      => 'Month',
         *'dayofweek'  => 'DayOfWeek',
         */

    /**
     * Set the minute
     *
     * @param string minute field
     * @return $this
     */
    public function setMinute($minute)
    {
        $this->jobContainer['Minute'] = $minute;

        return $this;
    }

    /**
     * Get minute string
     *
     * @return string
     */
    public function getMinute()
    {
        return $this->jobContainer['Minute'];
    }

    /**
     * Set the hour
     *
     * @param string $hour hour field
     * @return $this
     */
    public function setHour($hour)
    {
        $this->jobContainer['Hour'] = $hour;

        return $this;
    }

    /**
     * Get the hour field
     *
     * @return string
     */
    public function getHour()
    {
        return $this->jobContainer['Hour'];
    }

    /**
     * Set day of month
     *
     * @param string $dayOfMonth
     * @return $this
     */
    public function setDayOfMonth($dayOfMonth)
    {
        $this->jobContainer['DayOfMonth'] = $dayOfMonth;

        return $this;
    }

    /**
     * Get the day of month
     *
     * @return string
     */
    public function getDayOfMonth()
    {
        return $this->jobContainer['DayOfMonth'];
    }

    /**
     * Set month
     *
     * @param string $month month field
     * @return $this
     */
    public function setMonth($month)
    {
        $this->jobContainer['Month'] = $month;

        return $this;
    }

    /**
     * Get month field
     *
     * @return string
     */
    public function getMonth()
    {
        return $this->jobContainer['Month'];
    }

    /**
     * Set day of the week
     *
     * @param string $dayOfweek
     * @return $this
     */
    public function setDayOfWeek($dayOfWeek)
    {
        $this->jobContainer['DayOfWeek'] = $dayOfWeek;

        return $this;
    }

    /**
     * Get day of the week
     *
     * @return string
     */
    public function getDayOfWeek()
    {
        return $this->jobContainer['DayOfWeek'];
    }
    
    /**
     * Sets the command to be run
     * 
     * @param string $command Command to be executed
     * @return $this
     */
    public function setCommand($command)
    {
        $this->jobContainer['Command'] = $command;

        return $this;
    }

    /**
     * Get the command to be run
     * 
     * @return string Command to run
     */
    public function getCommand()
    {
        return $this->jobContainer['Command'];
    }

    /**
     * Sets the log file path
     * 
     * @param string $logFile Path to the log file
     * @return $this
     */
    public function setLogFile($logFile)
    {
        $this->jobContainer['LogFile'] = $logFile;

        return $this;
    }

    /**
     * Gets the log file path
     * 
     * @return string Log file path
     */
    public function getLogfile()
    {
        return $this->jobContainer['LogFile'];
    }

    /**
     * Sets the error log file path
     * 
     * @param string $path Path to the error log file
     * @return $this
     */
    public function setErrorFile($path)
    {
        $this->jobContainer['ErrorFile'] = $path;

        return $this;
    }

    /**
     * Gets the error log file path
     * 
     * @return string Path to the error log file
     */
    public function getErrorFile()
    {
        return $this->jobContainer['ErrorFile'];
    }

    /**
     * Sets the name for the cron
     * 
     * @param string $comments Comment / description of the crontab
     * @return $this
     */
    public function setName($name)
    {
        if (trim($name) == '')
        {
            $name = 'no name';
        }

        $this->jobContainer['Comments'] = ($name);

        return $this;
    }

    /**
     * Gets the name of a cron
     * 
     * @return string crontab comment / description
     */
    public function getName()
    {
        //return $this->job->getComments();
        return $this->jobContainer['Comments'];
    }

    /**
     * Clears all fields, etc.
     *
     * @return $this
     */
    public function clear()
    {
        $this->jobContainer = array();
        $this->job          = null;
        
        return $this;
    }

    /**
     * Creates a new Job
     *
     * @return $this
     */
    public function make()
    {
        $job = new Job;

        foreach ($this->jobContainer as $callbackPart => $cronData)
        {
            $callback = 'set' . $callbackPart;
            \call_user_func_array(array($job, $callback), array($cronData));
        }

        return $this->setJob($job);
    }

    /**
     * Sets the job
     *
     * @param Job $job
     * @return $this
     */
    public function setJob(Job $job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Gets the job that was already made
     *
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }
}
