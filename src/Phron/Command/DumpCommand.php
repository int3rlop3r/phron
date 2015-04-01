<?php namespace Phron\Command;

use Phron\Processor\FileOutput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DumpCommand extends AbstractCommand
{
    public function configure()
    {
        $description = 'task id(s) to dump [eg: 1 2 3 will output tasks 1, 2 & 3. 1-5 will output tasks 1, 2, 3, 4, 5]';

        $this->setName('dump')
             ->setDescription('Dumps selected tasks to a file.')
             ->setHelp('phron dump <ids>')
             ->addArgument(
                 'ids', 
                 InputArgument::OPTIONAL | 
                 InputArgument::IS_ARRAY, 
                 $description
             )
             ->addOption('file', null, InputOption::VALUE_REQUIRED, 'Where to dump?');
    }

    public function fire()
    {
        $taskBuffer     = '';
        $taskIdsToDump  = array();
        $taskIdsString  = $this->input->getArgument('ids');
        $taskOutputFile = $this->input->getOption('file');

        $output  = is_null($taskOutputFile) ? $this->output: new FileOutput($taskOutputFile);
        $taskIds = $this->entries->parseIds($taskIdsString);
        $this->entries->dump($taskIds, $output);
    }
}
