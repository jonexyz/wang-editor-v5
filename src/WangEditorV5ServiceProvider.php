<?php

namespace Jonexyz\WangEditorV5;

use Encore\Admin\Form;
use Encore\Admin\Admin;
use Illuminate\Support\ServiceProvider;

class WangEditorV5ServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(WangEditorV5 $extension)
    {
        if (! WangEditorV5::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'wang-editor-v5');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/wang-editor-v5')],
                'wang-editor-v5'
            );
        }

        Admin::booting(function () {
            Form::extend('wangEditor', Editor::class);
        });

        $this->app->booted(function () {
            WangEditorV5::routes(__DIR__.'/../routes/web.php');
        });
    }
}
