# Laravel Kanban

A laravel wrapper for the [jkanban](https://github.com/riktar/jkanban) library.

## Installation

You can install this package using composer.

```shell
composer require jinoantony/laravel-kanban
```

This package supports package auto-discovery, so you don't have to register it manually. If you want to manually register the provider, add the following line to `config/app.php` file.

```php
JinoAntony\Kanban\LaravelKanbanServiceProvider::class,
```

## Usage

This package uses [jkanban](https://github.com/riktar/jkanban) library under the hood. So don't forget to include `jkanban.min.js` and `jkanban.min.css` in your view files.

### Create kanban boards

You can use the artisan command to generate kanban boards.

```shell
php artisan kanban:make TaskKanban
```

This will create a new file `TaskKanban` in the `app/Kanban` directory.

By default the structure for the kanban board is like this.

```php
class TaskKanban extends Kanban
{
    /**
     * Get the list of boards
     *
     * @return KBoard[]
     */
    public function getBoards()
    {
        return [
            KBoard::make('board1')
                ->setTitle('Board1 title')
                ->canDragTo('board2'),

            KBoard::make('board2')
                ->setTitle('Board2 title')
                ->canDragTo('board3'),

            KBoard::make('board3')
                ->setTitle('Board3 title')
                ->canDragTo('board2')
                ->canDragTo('board1'),
        ];
    }

    /**
     * Get the data for each board
     *
     * @return array
     */
    public function data()
    {
        return [
            'board1' => [
                KItem::make('1')
                    ->setContent('Item1'),
                KItem::make('2')
                    ->setContent('Item2'),
            ],
            'board2' => [
                KItem::make('3')
                    ->setContent('Item3'),
                KItem::make('4')
                    ->setContent('Item4'),
            ],
            'board3' => [
                KItem::make('5')
                    ->setContent('Item5'),
                KItem::make('6')
                    ->setContent('Item6'),
            ],
        ];
    }

    public function build()
    {
        return $this->element('.kanban-board')
            ->margin('20px')
            ->width('365px');
    }

}
```

Create a view to render the board.

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kanban</title>
    <link rel="stylesheet" href="{{ asset('css/jkanban.min.css') }}" />
</head>
<body>
    <div class="kanban-board"></div>
    
    <script src="{{ asset('js/jkanban.min.js') }}"></script>
    {!! $kanban->scripts() !!}
</body>
</html>
```

Then in your controller,

```php
use App\Kanban\TaskKanban;

class TaskController extends Controller
{
    public function get(TaskKanban $kanban)
    {
        return $kanban->render('kanban');
    }
}
```

Now add a route in `web.php`.

```php
Route::get('task', 'TaskController@get');
```
