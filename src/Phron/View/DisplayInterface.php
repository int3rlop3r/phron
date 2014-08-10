<?php namespace Phron\View;

/**
 * Description of Viewable
 *
 * @author jonathan
 */
interface DisplayInterface
{
    /**
     * Returns stuff to display
     */
    public function getOutput();
    
    /**
     * Displays stuff
     */
    public function render();
}
