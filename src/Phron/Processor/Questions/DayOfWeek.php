<?php namespace Phron\Processor\Questions;

use Cron\FieldFactory;

/**
 * Description of DayOfWeek
 *
 * @author jonathan
 */
class DayOfWeek extends Questionable 
{
    /**
     * @var int position of the field
     */
    const POSITION = 4;
    
    /**
     * @var list of presets
     */
    protected $presets = array(
        '*',
        '1-5',
        '0,6',
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
        return "Pick an option for day of the week (blank to enter custom value): ";
    }
    
    /**
     * Fetches the question
     * 
     * @return string Question
     */
    public function getOptions()
    {
        return array(
            "Every Weekday", 
            "Monday-Friday", 
            "Weekend Days", 
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
        return "Enter custom value for day of the week [0-7]";
    }
}
