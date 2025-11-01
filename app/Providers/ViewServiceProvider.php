<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\CategoryPublic;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Compartir las categorías con todas las vistas del layout público
        View::composer('components.public.*', function ($view) {
            $view->with('categories', CategoryPublic::with('subcategories')->get());
        });
    }
}
