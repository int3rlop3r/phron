<?php namespace Phron\View;

use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Output\OutputInterface;

class TaskTableView
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var Table
     */
    protected $table;

    public static function formatRows(array $rows)
    {
        $formattedRows = array();
        $key = 0;

        foreach ($rows as $row) {
            $key++;
            $formattedRows[] = array(
                'sr_no'       => $key,
                'expresstion' => sprintf(
                                        "%s %s %s %s %s",
                                        $row->getMinute(),
                                        $row->getHour(),
                                        $row->getDayOfMonth(),
                                        $row->getMonth(),
                                        $row->getDayOfWeek()
                                    ),
                'command'     => $row->getCommand(),
                'comments'    => $row->getComments(), 
                'log_file'    => $row->getLogFile(), 
                'error_log'   => $row->getErrorFile(),
            );
        }

        return $formattedRows;
    }

    /**
     * Renders the table.
     *
     * @return string Output inside a table
     */
    public static function render(TableHelper $table, OutputInterface $output, $headers, $rows)
    {
        $rows = self::formatRows($rows);
        return $table->setHeaders($headers)
                    ->setRows($rows)
                    ->render($output);
    }
}
