<?php namespace Phron\Command;

/**
 * Description of DeleteCommand
 *
 * @author jonathan
 */

use Cron\FieldFactory;
use Phron\Processor\Entries;
use Phron\Processor\JobBuilder;
use Symfony\Component\Console\Input\InputArgument;

class DeleteCommand extends AbstractCommand
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
        $description = 'task id(s) to delete [eg: 1 2 3 will delete tasks '
                     . '1, 2 & 3. 1-5 will delete tasks 1, 2, 3, 4, 5]';
        
        $this->setName('delete')
             ->setDescription('Delete tasks')
             ->setHelp('Delete tasks')
             ->addArgument(
                'taskIds', 
                InputArgument::IS_ARRAY,               // make this optional and add a delete all option 
                $description
            );
    }
    
    public function fire()
    {
        //$tasksToDelete = array();
        $taskIds = $this->input->getArgument('taskIds');
        $tasksToDelete = $this->entries->parseIds($taskIds);

        if (!empty($taskIds))
        {
            if ($this->confirm('Delete ' . count($tasksToDelete) . ' task(s)? '))
            {
                $this->entries->delete($tasksToDelete);
            }
            else
            {
                $this->writeln('Cancelled');
            }
        }
        else
        {
            if ($this->confirm('Delete all tasks? '))
            {
                $this->entries->clear();
            }
            else
            {
                $this->writeln('Cancelled');
            }
        }

        //var_dump($tasksToDelete);
        //die();
        $this->entries->save();
        $this->writeln('Done');
    }
}
