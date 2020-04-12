<?php

namespace JinoAntony\Kanban;

use Illuminate\Support\ServiceProvider;
use JinoAntony\Kanban\Commands\KanbanMakeCommand;

class LaravelKanbanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-kanban');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/laravel-kanban'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                KanbanMakeCommand::class,
            ]);
        }
    }

    public function register()
    {
        
    }
}