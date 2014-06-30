<?php namespace Phron\Processor;


class Scheduler
{
    private $stack = array(
        'minutes',
        'hours',
        'days',
        'months',
        'weekdays',
        'command',
    );
    
    private $answers = array();
//         'minutes'  => '*',
//         'hours'    => '*',
//         'days'     => '*',
//         'months'   => '*',
//         'weekdays' => '*',
//         'command'  => '-',
//     );

    private $questions = array();

    private $subQuestions  = array();
    
    private $stackItemException;

    public function __construct()
    {
        $this->stackItemException = new \Exception('Invlaid Question Key');
        
        // initialise the answers array
        foreach ($this->stack as $item) {
            if ($item == 'command') {
                $this->answers[$item] = '-';                
            } else {
                $this->answers[$item] = '*';
            }
        }
    }

    /**
     * Returns an array of answers
     *
     * @return array
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Sets a value of an answer using a question's key
     *
     * @param string $stackItem
     * @param string $answer
     * @throws \Exception
     * @return void
     */
    public function answerQuestion($stackItem, $answer = '*')
    {
        if (isset($this->answers[$stackItem])) {
            $this->answers[$stackItem] = strval($answer);
        } else {
            throw $this->stackItemException;
        }

        return $this;
    }

    /**
     * Gets an answers based on the question key
     *
     * @param string $stackItem
     * @throws \Exception
     * @return string
     */
    public function getAnswer($stackItem)
    {
        if (!isset($this->answers[$stackItem])) {
            throw $this->stackItemException;
        }

        return $this->answers[$stackItem];
    }

    /**
     * Returns an array of questions
     * 
     * @return array
     */
    public function getQuestions()
    {
        return $this->questions;
    }
    
    public function getQuestion($stackItem)
    {
        //
    }
    
    /**
     * Returns an array of sub questions
     * 
     * @return array
     */
    public function getSubQuestions()
    {
        return $this->subQuestions;
    }
    
    /**
     * Returns a stack
     * 
     * @return array
     */
    public function getStack()
    {
        return $this->stack;
    }
}
