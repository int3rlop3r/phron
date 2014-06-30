<?php namespace Phron\Processor;


class Scheduler
{
    private $answers = array();

    private $stack = array(
        'minutes',
        'hours',
        'days',
        'months',
        'weekdays',
        'command',
    );

    private $questions = array(
            'Every Minute ( y / n ): ',
            'Every Hour  ( y / n ): ',
            'Every Day  ( y / n ): ',
            'Every Month ( y / n ): ',
            'Every Day of the week ( y / n ): ',
            'Command to execute: ',
        );

    private $subQuestions  = array(
            'Enter Minutes [0-59]: ',
            'Enter Hours [0-23]: ',
            'Enter Days [1-31]: ',
            'Enter Months [1-12]: ',
            'Enter Day of the week [0-7]: ',
        );

    public function __construct()
    {
        $this->initAnswers();
        $this->initQuestions();
        $this->initSubQuestions();
    }

    /**
     * Initializes the answers array
     *
     * @return $this
     */
    private function initAnswers()
    {
        foreach ($this->stack as $item) {

            if ($item == 'command') {
                $this->answers[$item] = '-';
            } else {
                $this->answers[$item] = '*';
            }

        }

        return $this;
    }

    /**
     * Initializes the questions array
     * 
     * @return $this
     */
    public function initQuestions()
    {
        foreach ($this->questions as $key => $question) {

            if (!isset($this->stack[$key])) {
                throw new Exception('Stack offset does not exist: ' . $key);
            }

            $newKey = $this->stack[$key];

            $this->questions[$newKey] = $question;

            unset($this->questions[$key]);
        }
    }

    /**
     * Initializes the questions array
     * 
     * @return $this
     */
    public function initSubQuestions()
    {
        foreach ($this->subQuestions as $key => $question) {

            if (!isset($this->stack[$key])) {
                throw new Exception('Stack offset does not exist: ' . $key);
            }

            $newKey = $this->stack[$key];

            $this->subQuestions[$newKey] = $question;

            unset($this->subQuestions[$key]);
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
            throw new \Exception('Invlaid Stack Item: ' . $stackItem);
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
            throw new \Exception('Invlaid Stack Item: ' . $stackItem);
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

    /**
     * Returns a question based on the stack item
     *
     * @param string $stackItem
     * @return string
     */
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
     * Returns a sub question based on the stack item
     * 
     * @param string $stackItem
     * @return array
     */
    public function getSubQuestion($stackItem)
    {
        //
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
