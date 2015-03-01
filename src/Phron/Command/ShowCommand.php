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
    /**
     * @param Entries $entries
     * @param JobBuilder $jobBuilder
     * @param FieldFactory $fieldFactory
     */
    public function __construct(Entries $entries, JobBuilder $jobBuilder, FieldFactory $fieldFactory)
    {
        parent::__construct($entries, $jobBuilder, $fieldFactory);
    }
    
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
