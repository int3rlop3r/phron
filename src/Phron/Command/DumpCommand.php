<?php namespace Phron\Command;

use Cron\FieldFactory;
use Phron\Processor\JobBuilder;
use Phron\Processor\Entries;
use Phron\Processor\Questions\QuestionFactory;
use Symfony\Component\Console\Input\InputArgument;
use Cron\CronExpression;


class DumpCommand extends AbstractCommand
{
    public function __construct(Entries $entries, JobBuilder $jobBuilder, FieldFactory $fieldFactory)
    {
        parent::__construct($entries, $jobBuilder, $fieldFactory);
    }
    
    public function configure()
    {
        $description = 'task id(s) to delete [eg: 1 2 3 '
            . 'will delete tasks 1, 2 & 3. 1-5 will delete tasks 1, 2, 3, 4, 5]';

        $this->setName('dump')
             ->setDescription('Dumps selected tasks to a file.')
             ->setHelp('phron dump <ids>')
             ->addArgument('outputfile', InputArgument::REQUIRED, 'file to write to')
             ->addArgument('ids', InputArgument::IS_ARRAY | InputArgument::REQUIRED, $description);
    }

    public function fire()
    {
        $taskBuffer     = '';
        $taskIdsToDump  = array();
        $taskIdsString  = $this->input->getArgument('ids');
        $taskOutputFile = $this->input->getArgument('outputfile');

        $taskIds = $this->entries->parseIds($taskIdsString);
        $this->entries->dumpToFile($taskOutputFile, $taskIds);
    }
}
