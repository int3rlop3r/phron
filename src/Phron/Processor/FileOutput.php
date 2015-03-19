<?php namespace Phron\Processor;

use Crontab\CrontabFileHandler;
use Symfony\Component\Console\Output\Output;

class FileOutput extends Output
{

    /**
     * @var string File to write to.
     */
    protected $filepath;

    /**
     * @param string $filepath Path to the output file
     */
    public function __construct($filepath = null)
    {
        parent::__construct(self::VERBOSITY_NORMAL, false, null);
        $this->filepath = $filepath;
        file_put_contents($filepath, "");
    }

    /**
     * Writes a line to the file.
     *
     * @param string $text Text to write.
     */
    public function doWrite($text, $newline)
    {
        $newline = PHP_EOL;
        file_put_contents($this->filepath, $text . $newline, FILE_APPEND);
    }
}
