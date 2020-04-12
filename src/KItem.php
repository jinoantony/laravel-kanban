<?php

namespace JinoAntony\Kanban;

class KItem
{
    /**
     * Id of the board item
     *
     * @var string
     */
    protected $id;

    /**
     * Content of the item
     *
     * @var string
     */
    protected $content;

    /**
     * Data attributes to be added to the item element
     *
     * @var array
     */
    protected $customProps = [];

    /**
     * Create a new Kanban Item
     *
     * @param string $id
     * @param string $content
     */
    public function __construct(string $id = '', string $content = '')
    {
        $this->id = $id;
        $this->content = $content;
    }

    /**
     * Create a new Kanban Item
     *
     * @param string $id
     * @param string $content
     * @return static
     */
    public static function make($id = '', $content = '')
    {
        return new static($id, $content);
    }

    /**
     * Set the id of the item
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the content of the item
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Add custom data-attributes to the item element
     *
     * @param array $props
     * @return $this
     */
    public function withCustomProps(array $props)
    {
        $this->customProps = $props;
        
        return $this;
    }

    /**
     * Get the formatted item
     *
     * @return array
     */
    public function getFormattedItem()
    {
        $item = [
            'id' => $this->id,
            'title' => $this->content,
        ];

        foreach ($this->customProps as $prop => $value) {
            $item[$prop] = $value;
        }

        return $item;
    }
}