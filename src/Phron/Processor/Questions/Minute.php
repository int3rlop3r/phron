<?php namespace Phron\Processor\Questions;

use Cron\FieldFactory;

/**
 * Description of Minute
 *
 * @author jonathan
 */
class Minute extends Questionable
{
    /**
     * @var int position of the field
     */
    const POSITION = 0;
    
    /**
     * @var list of presets
     */
    protected $presets = array(
        '*',
        '*/2',
        '1-59/2',
        '*/5',
        '*/15',
        '*/30',
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
     * Fetches available options
     * 
     * @return array list of options
     */
    public function getQuestion()
    {
        return "Pick an option for minute: ";
    }
    
    /**
     * Fetches the question
     * 
     * @return string Question
     */
    public function getOptions()
    {
        return array(
            "Every Minute", 
            "Even Minutes", 
            "Odd Minutes", 
            "Every 5 Minutes", 
            "Every 15 Minutes", 
            "Every 30 Minutes", 
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
        return "Enter custom value for minutes [0-59]: ";
    }
}
