<?php namespace Phron\Command;

/**
 * Description of ShowCommand
 *
 * @author jonathan
 */

class ShowCommand extends AbstractCommand
{
    public function configure()
    {
        $this->setName('show')
             ->setDescription('Displays all crons.')
             ->setHelp('Displays all crons.');
    }
    
    public function fire()
    {
        $table = $this->getHelper('table');
        $tasks = $this->entries->all();
        $this->displayTasks($table, $tasks);
    }
}
