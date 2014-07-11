<?php namespace Phron\Processor;


/**
 * @author Jonathan Fernandes <int3rlop3r@yahoo.in>
 */

use Phron\Processor\Generator;

class Entries
{
    private $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }
    
    /**
     * Returns the generator
     * @return Generator Generator object
     */
    public function getGenerator()
    {
        return $this->generator;
    }
    
    public function add()
    {
        //
    }
    
}