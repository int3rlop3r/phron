<?php namespace Phron\Processor\Questions;

use Cron\FieldFactory;

/**
 * Description of DayOfMonth
 *
 * @author jonathan
 */
class DayOfMonth extends Questionable
{
    /**
     * @var int position of the field
     */
    const POSITION = 2;
    
    /**
     * @var list of presets
     */
    protected $presets = array(
        '*',
        '*/2',
        '1-31/2',
        '*/5',
        '*/10',
        '*/15',
    );
    
    /**
     * @param FieldFactory $fieldFactory
     */
    public function __construct(FieldFactory $fieldFactory)
    {
        parent::__construct($fieldFactory);
    }
    
    public function getPosition()
    {
        return self::POSITION;
    }
    
    /**
     * Fetches available options
     * 
     * @return array list of options
     */
    public function getQuestion()
    {
        return "Pick an option for day of the month (blank to enter custom value): ";
    }
    
    /**
     * Fetches the question
     * 
     * @return string Question
     */
    public function getOptions()
    {
        return array(
            "Every Day", 
            "Even Days", 
            "Odd Days", 
            "Every 5 Days", 
            "Every 10 Days", 
            "Every Half Month", 
            "Enter Custom Value", 
            null, 
        );
    }
    
    /**
     * Gets question that prompts the user to enter a custom value for a field
     * 
     * @return string
     */
    public function getCustomValueQuestion()
    {
        return "Enter custom value for day of the month [1-31]";
    }
}
