<?php namespace Phron\Command;

/**
 * Description of DeleteCommand
 *
 * @author jonathan
 */

use Cron\FieldFactory;
use Phron\Processor\Entries;
use Phron\Processor\Generator;
use Symfony\Component\Console\Input\InputArgument;

class DeleteCommand extends AbstractCommand
{
    /**
     * @param Entries $entries
     * @param Generator $generator
     * @param FieldFactory $fieldFactory
     */
    public function __construct(Entries $entries, Generator $generator, FieldFactory $fieldFactory)
    {
        parent::__construct($entries, $generator, $fieldFactory);
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
        
        if (empty($taskIds))
        {
            // delete all tasks
            die("Deleting all tasks.\n");
        }
        else
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
        }
        
        //var_dump($tasksToDelete);
        $this->entries->deleteByIds($tasksToDelete);
    }
}