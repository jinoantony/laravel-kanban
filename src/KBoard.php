<?php

namespace JinoAntony\Kanban;

class KBoard
{
    /**
     * Kanban items
     *
     * @var KItem[]
     */
    protected $items = [];

    /**
     * Id of the board
     *
     * @var string
     */
    protected $id;

    /**
     * Title of the board
     *
     * @var string
     */
    protected $title;

    /**
     * Css class to add at the title
     *
     * @var string
     */
    protected $class;

    /**
     * Ids of boards where items can be dropped
     *
     * @var array
     */
    protected $dragTo = [];

    /**
     * Create a new Kanban Board
     *
     * @param string $id
     * @param string $title
     * @param array $items
     */
    public function __construct(string $id = '', string $title = '', array $items = [])
    {
        $this->id = $id;
        $this->title = $title;
        $this->items = $items;
    }

    /**
     * Create a new Kanban Board
     *
     * @param string $id
     * @param string $title
     * @param array $items
     * @return static
     */
    public static function make(string $id = '', string $title = '', array $items = [])
    {
        return new static($id, $title, $items);
    }

    /**
     * Set the id of the board
     *
     * @param string $id
     * @return $this
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the title of the board
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the css class for the board
     *
     * @param string $class
     * @return $this
     */
    public function setClass(string $class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Set the draggable boards
     *
     * @param KBoard|string $board
     * @return $this
     */
    public function canDragTo($board)
    {
        $this->dragTo[] = $board instanceof KBoard
            ? $board->getId()
            : $board;

        return $this;
    }

    /**
     * Set items for the board
     *
     * @param array $items
     * @return $this
     */
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Add an item to the existing list of items
     *
     * @param KItem $item
     * @return $this
     */
    public function addItem(KItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Get the ID of the board
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the formatted board 
     *
     * @return array
     */
    public function getFormattedBoard()
    {
        $board = [
            'id' => $this->id,
            'title' => $this->title,
            'item' => $this->getFormattedItems(),
        ];

        if ($this->class) {
            $board['class'] = $this->class;
        }

        if ($this->dragTo) {
            $board['dragTo'] = $this->dragTo;
        }

        return $board;
    }

    /**
     * Get the formatted items
     *
     * @return array
     */
    protected function getFormattedItems()
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $item->getFormattedItem();
        }

        return $items;
    }
    
}