<?php namespace Phron\View;

/**
 * Description of Display
 *
 * @author jonathan
 */

class Display implements DisplayInterface
{
    
    private $view;
    
    public function __construct(Viewable $view)
    {
        $this->view = $view;
    }
    
    public function render()
    {
        //
    }
    
    public function getOutput()
    {
        //
    }
}
