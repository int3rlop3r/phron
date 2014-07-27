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
     * @param FieldFactory $fieldFactory
     */
    public function __construct(FieldFactory $fieldFactory)
    {
        $this->fieldFactory = $fieldFactory;
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
            
            if ($passes === false) {
                throw new \RuntimeException("Invalid value entered");
            }
            
            return $answer;
        };
    }
    
    /**
     * Gets the value of a field based on the selection of the user
     * 
     * @param int $selection
     * @return string
     */
    public function getBySelection($selection)
    {
        return isset($this->presets[$selection]) ? $this->presets[$selection]: null;
    }
    
    /**
     * @return FieldFactory
     */
    public function getFieldFactory()
    {
        return $this->fieldFactory;
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
     * Gets the position of the field
     * 
     * @return int
     */
    abstract public function getPosition();
    
    /**
     * Gets question that prompts the user to enter a custom value for a field
     * 
     * @return string
     */
    abstract public function getCustomValueQuestion();
}
