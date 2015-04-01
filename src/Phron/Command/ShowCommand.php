<?php namespace Phron\Command;

/**
 * Description of ShowCommand
 *
 * @author jonathan
 */

use Cron\FieldFactory;
use Phron\Processor\JobBuilder;
use Phron\Processor\Entries;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Exception\InvalidArgumentException;

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
