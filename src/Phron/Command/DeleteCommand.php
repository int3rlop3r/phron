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
        $tasksToDelete = array();
        $taskIds = $this->input->getArgument('taskIds');

        if (!empty($taskIds))
        {
            foreach ($taskIds as $taskIdString)
            {
                if (strpos($taskIdString, '-') !== false)
                {
                    $idParts = explode('-', $taskIdString);

                    if (count($idParts) != 2) { continue; }

                    $idRange = range(intval($idParts[0]), intval($idParts[1]));

                    $tasksToDelete = array_merge($tasksToDelete, $idRange);
                }
                else
                {
                    $tasksToDelete[] = intval($taskIdString);
                }
            }
            
            if ($this->confirm('Delete ' . count($tasksToDelete) . ' task(s)? '))
            {
                foreach ($tasksToDelete as $taskId)
                {
                    $this->entries->delete($taskId);
                }
                $this->entries->save();
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
                $this->entries->clear()->save();
            }
            else
            {
                $this->writeln('Cancelled');
            }
        }
        
        $this->writeln('Done');
    }
}
