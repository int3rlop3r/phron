<?php namespace Phron\Command;

/**
 * Description of DeleteCommand
 *
 * @author jonathan
 */

use Symfony\Component\Console\Input\InputArgument;

class DeleteCommand extends AbstractCommand
{
    public function configure()
    {
        $description = 'task id(s) to delete [eg: 1 2 3 will delete tasks '
                     . '1, 2 & 3. 1-5 will delete tasks 1, 2, 3, 4, 5]';
        
        $this->setName('delete')
             ->setDescription('Delete tasks')
             ->setHelp('Delete tasks')
             ->addArgument('taskIds', InputArgument::IS_ARRAY, $description);
    }
    
    public function fire()
    {
        $taskIds = $this->input->getArgument('taskIds');
        $tasksToDelete = $this->entries->parseIds($taskIds);
        $message = 'Cancelled';

        if (!empty($taskIds) && $this->confirm('Delete ' . count($tasksToDelete) . ' task(s)? '))
        {
                $this->entries->delete($tasksToDelete);
                $message = 'Done';
        }
        elseif ($this->confirm('Delete all tasks? '))
        {
                $this->entries->clear();
                $message = 'Done';
        }

        $this->entries->save();
        $this->writeln($message);
    }
}
