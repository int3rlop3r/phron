<?php namespace Phron\Processor;


class Scheduler
{
    private $answers = array(
        'minutes'  => '*',
        'hours'    => '*',
        'days'     => '*',
        'months'   => '*',
        'weekdays' => '*',
        'command'  => '-',
    );

    private $mainQuestions = array();

    private $subQuestions  = array();

    private $questionKeyException;

    public function __construct()
    {
        $this->questionKeyException = new \Exception('Invlaid Question Key');
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
     * @param string $questionKey
     * @param string $answer
     * @throws \Exception
     * @return void
     */
    public function answerQuestion($questionKey, $answer = '*')
    {
        if (isset($this->answers[$questionKey])) {
            $this->answers[$questionKey] = $answer;
        } else {
            throw $this->questionKeyException;
        }

        return $this;
    }

    /**
     * Gets an answers based on the question key
     *
     * @param string $questionKey
     * @throws \Exception
     * @return string
     */
    public function getAnswer($questionKey)
    {
        if (!isset($this->answers[$questionKey])) {
            throw $this->questionKeyException;
        }

        return $this->answers[$questionKey];
    }


}
