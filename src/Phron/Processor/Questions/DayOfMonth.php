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
        return "Pick an option for day of the month: ";
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
        );
    }

    /**
     * Gets question that prompts the user to enter a custom value for a field
     * 
     * @return string
     */
    public function getCustomValueQuestion()
    {
        return "Enter custom value for day of the month [1-31]: ";
    }

}
