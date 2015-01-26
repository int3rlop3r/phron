<?php namespace Phron\View;

use Symfony\Component\Console\Helper\TableHelper;

class TableView
{
    /**
     * @var TableHelper $table Table helper.
     */
    private $table;

    /**
     * @var array $headers Table headers.
     */
    private $headers;

    /**
     * @var array $content Table body / content.
     */
    private $content;

    /**
     * @param
     */
    public function __construct(TableHelper $table)
    {
        $this->table = $table;
    }

    /**
     * Sets the table content.
     *
     * @param array $headers
     * @param array $content
     * @return $this
     */
    public function setContent(array $headers, array $content)
    {
        $this->headers = $headers;
        $this->content = $content;
        return $this;
    }

    /**
     * Renders the table.
     *
     * @return string
     */
    public function render()
    {
        
    }
}
