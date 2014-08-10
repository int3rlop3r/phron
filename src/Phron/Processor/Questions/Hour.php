<?php namespace Phron\Processor\Questions;

use Cron\FieldFactory;

/**
 * Description of Hour
 *
 * @author jonathan
 */
class Hour extends Questionable 
{
    /**
     * @var int position of the field
     */
    const POSITION = 1;
    
    /**
     * @var list of presets
     */
    protected $presets = array(
        '*', 
        '*/2',
        '1-23/2',
        '*/6',
        '*/12',
        null, 
    );
    
    /**
     * @param FieldFactory $fieldFactory
     */
    public function __construct(FieldFactory $fieldFactory)
    {
        parent::__construct($fieldFactory, self::POSITION);
    }
    
    /**
     * Fetches the question
     * 
     * @return string Question
     */
    public function getOptions()
    {
        return array(
            "Every Hour",  
            "Even Hours", 
            "Odd Hours", 
            "Every 6 Hours", 
            "Every 12 Hours", 
            "Enter Custom Value", 
        );
    }
    
    /**
     * Fetches available options
     * 
     * @return array list of options
     */
    public function getQuestion()
    {
        return "Pick an option for hour: ";
    }
    
    /**
     * Gets question that prompts the user to enter a custom value for a field
     * 
     * @return string
     */
    public function getCustomValueQuestion()
    {
        return "Enter custom value for hours [0-23]: ";
    }
}
