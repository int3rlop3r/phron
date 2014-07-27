<?php namespace Phron\Processor\Questions;

/**
 * QuestionFactory creates a Questionable object.
 *
 * @author jonathan
 */
class QuestionFactory
{
    /**
     * Creates an instance for the class name
     * 
     * @return Questionable
     */
    public static function create($className, \Cron\FieldFactory $fieldFactory)
    {
        $className = "\\Phron\\Processor\\Questions\\$className";
        
        return new $className($fieldFactory);
    }
}
