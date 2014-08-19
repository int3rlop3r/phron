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
        $this->setName('delete')
             ->setDescription('Delete tasks')
             ->setHelp('Delete tasks')
             ->addArgument(
                 'taskIndexString', 
                 InputArgument::IS_ARRAY,               // make this optional and add a delete all option 
                 'task id(s) to delete ("," separated)'
            );
    }
    
    public function fire()
    {
        $taskIds = $this->input->getArgument('taskIndexString');
        
        $tasksToDelete = array();
        
        foreach ($taskIds as $taskIdString) {
            
            if (strpos($taskIdString, '-') !== false) {
                $idParts = explode('-', $taskIdString);
                
                if (count($idParts) != 2) { continue; }
                
                $idRange = range(intval($idParts[0]), intval($idParts[1]));
                
                $tasksToDelete = array_merge($tasksToDelete, $idRange);
            } else {
                
                $tasksToDelete[] = intval($taskIdString);
            }
        }
        
        $ids = array_unique($tasksToDelete);
        
        var_dump($ids);
    }
}