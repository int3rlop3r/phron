<?php namespace Phron\Processor\Questions;

use Cron\FieldFactory;

/**
 * Description of Questionable
 *
 * @author jonathan
 */
abstract class Questionable
{

    const CUSTOM_QUESTION = "Enter custom value for ";

    /**
     * @var FieldFactory
     */
    protected $fieldFactory;

    /**
     * @var int position of the field
     */
    protected $position;

    /**
     * @param FieldFactory $fieldFactory
     */
    public function __construct(FieldFactory $fieldFactory, $position)
    {
        $this->fieldFactory = $fieldFactory;
        $this->position     = $position;
    }

    /**
     * Gets the value of a field based on the selection of the user
     * 
     * @param int $selection
     * @return string
     */
    public function getBySelection($selection)
    {
        return isset($this->presets[$selection]) ? $this->presets[$selection] : null;
    }

    /**
     * @return FieldFactory
     */
    public function getFieldFactory()
    {
        return $this->fieldFactory;
    }

    /**
     * Gets the position of the field
     * 
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Returns a closure to validate the user input
     * 
     * @param string $value
     * @return callable
     */
    public function getValidator()
    {
        $that = $this;

        return function($answer) use ($that)
        {
            $passes = $that->getFieldFactory()
                ->getField($that->getPosition())
                ->validate($answer);

            if ($passes === false)
            {
                throw new \RuntimeException("Invalid value entered");
            }

            return $answer;
        };
    }

    /**
     * Fetches the question
     * 
     * @return string Question
     */
    abstract public function getQuestion();

    /**
     * Fetches available options
     * 
     * @return array list of options
     */
    abstract public function getOptions();

    /**
     * Gets question that prompts the user to enter a custom value for a field
     * 
     * @return string
     */
    abstract public function getCustomValueQuestion();
}
