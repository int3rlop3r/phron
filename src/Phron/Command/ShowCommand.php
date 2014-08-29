<?php namespace Phron\Command;

/**
 * Description of ShowCommand
 *
 * @author jonathan
 */

use Cron\FieldFactory;
use Phron\Processor\Generator;
use Phron\Processor\Entries;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Exception\InvalidArgumentException;

class ShowCommand extends AbstractCommand
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
        $this->setName('show')
             ->setDescription('Display tasks')
             ->setHelp('Display tasks')
             ->addOption(
                'limit', 
                '-l', 
                InputOption::VALUE_OPTIONAL, 
                'Set limit of tasks to display [eg: 1-3 displays first 3 tasks]', 
                null
            );
    }
    
    public function fire()
    {
        $limit = $this->input->getOption('limit');
        
        if (is_null($limit)) {
            // get all
            $jobs = $this->entries->all();
        } else {
            $limitPieces = explode('-', $limit);
            
            if (count($limitPieces) > 2)
            {
                throw new InvalidArgumentException("Limit accepts 2 arguments");
            }
            
            $start  = isset($limitPieces[0]) ? intval($limitPieces[0]) : 0; # code smell
            $length = isset($limitPieces[1]) ? intval($limitPieces[1]) : 1;
            
            $start--; // coz people being with 1  as the first number! :p
            
            $jobs = $this->entries->getByRange($start, $length);
        }
        
        var_dump($jobs);
    }
}
