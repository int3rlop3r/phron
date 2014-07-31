<?php namespace Phron\Processor\Questions;

use Cron\FieldFactory;

/**
 * Description of Month
 *
 * @author jonathan
 */
class Month extends Questionable 
{
    /**
     * @var int position of the field
     */
    const POSITION = 3;
    
    /**
     * @var list of presets
     */
    protected $presets = array(
        '*', 
        '*/2', 
        '1-11/2', 
        '*/4', 
        '*/6', 
        null, 
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
        return "Pick an option for month: ";
    }
    
    /**
     * Fetches the question
     * 
     * @return string Question
     */
    public function getOptions()
    {
        return array(
            "Every Month", 
            "Even Months", 
            "Odd Months", 
            "Every 4 Months", 
            "Every Half Year", 
            "Enter Custom Value", 
        );
    }
    
    /**
     * Gets question that prompts the user to enter a custom value for a field
     * 
     * @return string
     */
    public function getCustomValueQuestion()
    {
        return "Enter custom value for month [1-12]: ";
    }
}
