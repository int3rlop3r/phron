<?php namespace Phron\Command;

use Cron\FieldFactory;
use Phron\Processor\JobBuilder;
use Phron\Processor\Entries;
use Phron\Processor\Questions\QuestionFactory;
use Symfony\Component\Console\Input\InputArgument;
use Cron\CronExpression;


class ExplainCommand extends AbstractCommand
{
    public function __construct(Entries $entries, JobBuilder $jobBuilder, FieldFactory $fieldFactory)
    {
        parent::__construct($entries, $jobBuilder, $fieldFactory);
    }
    
    public function configure()
    {
        $this->setName('explain')
             ->setDescription('Explains the cron entry by displaying a time range.')
             ->setHelp('phron explain <id>')
             ->addArgument('id', InputArgument::REQUIRED, 'task id to explain')
             ->addArgument('range', InputArgument::OPTIONAL, 'generates dates upto "range" times');
    }

    /**
     * Render the table and display the time range.
     *
     * @param mixed $table SymfonyTableHelper
     * @param array $rows Table rows
     * @return string Rendered table
     */
    public function renderTable($table, array $rows)
    {
        $table->setHeaders(array('Date', 'Command'))
            ->setRows($rows)
            ->render($this->output);
    }

    public function fire()
    {
        $id        = $this->input->getArgument('id');
        $range     = $this->input->getArgument('range')?: 5;
        $table     = $this->getHelper('table');
        $tableRows = array();

        $job = $this->entries->find($id);

        if (!is_null($job))
        {
            $textEntry = $job->render();
            $pieces = explode(' ', $textEntry);
            $expressionString = implode(' ', array_slice($pieces, 0, 5));
            $cron = CronExpression::factory($expressionString);
            $command = $job->getCommand();
            
            foreach ($cron->getMultipleRunDates($range) as $date) {
                $tableRows[] = array(
                    'date'    => $date->format('Y-m-d H:i:s'),
                    'command' => $command,
                );
            }

            $this->renderTable($table, $tableRows);
        }
        else
        {
            $this->writeln('No such job');
        }
    }
}
