<?php

namespace JinoAntony\Kanban;

abstract class Kanban
{
    /**
     * Kanban Boards
     *
     * @var Kboard[]
     */
    protected $boards;

    /**
     * Selector of kanban conatiner
     *
     * @var string
     */
    protected $element;

    /**
     * Margin between boards
     *
     * @var string
     */
    protected $gutter = '20px';

    /**
     * Width of the boards
     *
     * @var string
     */
    protected $width = '250px';

    /**
     * Create new Kanban
     *
     * @param array $boards
     */
    public function __construct(array $boards = [])
    {
        $this->boards = $boards;
    }

    /**
     * Set the kanban container element
     *
     * @param string $element
     * @return $this
     */
    public function element(string $element)
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Set the margin between boards
     *
     * @param string $margin
     * @return $this
     */
    public function margin(string $margin)
    {
        $this->margin = $margin;

        return $this;
    }

    /**
     * Set the width of the container
     *
     * @param string $width
     * @return $this
     */
    public function width(string $width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Attach the kanban boards
     *
     * @param KBoard[] $boards
     * @return $this
     */
    public function boards(array $boards)
    {
        $this->boards = $boards;

        return $this;
    }

    /**
     * Add a new board to the boards list
     *
     * @param KBoard $board
     * @return $this
     */
    public function addBoard(KBoard $board)
    {
        $this->boards[] = $board;

        return $this;
    }

    /**
     * Render the kanban board
     *
     * @param string $view
     * @param array $viewData
     * @return \Illuminate\Contracts\View\View
     */
    public function render(string $view, array $viewData = [])
    {
        $this->boards($this->getBoards());
        $data = $this->data();

        foreach ($this->boards as $board) {
            $id = $board->getId();
            $board->setItems($data[$id]);
        }

        $this->build();

        return view($view, array_merge($viewData, ['kanban' => $this]));
    }

    /**
     * Render the scripts for kanban
     *
     * @return string
     */
    public function scripts()
    {
        return view('kanban.scripts', [
            'element' => $this->element,
            'margin' => $this->gutter,
            'width' => $this->width,
            'boards' => $this->formatBoards()
        ])->render();
    }

    /**
     * Format the kanban boards
     *
     * @return array
     */
    protected function formatBoards()
    {
        $formattedBoards = [];

        foreach ($this->boards as $board) {
            $formattedBoards[] = $board->getFormattedBoard();
        }

        return $formattedBoards;
    }

    /**
     * Get the data for each board
     *
     * @return array
     */
    abstract public function data();

    /**
     * Get the list of boards
     *
     * @return KBoard[]
     */
    abstract public function getBoards();

    /**
     * Build the kanban board
     *
     * @return void
     */
    public function build()
    {
        return $this->element('.kanban');
    }
}