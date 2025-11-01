<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\Admin\CategoryPublicController;
use App\Http\Controllers\Admin\SubcategoryPublicController;
use App\Http\Controllers\Admin\ProductPublicController;
use App\Http\Controllers\Admin\FeaturedProductController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Admin\CitaController;
use App\Http\Controllers\Admin\DiaDisponibleController;

/*
|--------------------------------------------------------------------------
| 🔹 RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Página principal
Route::get('/', [PublicController::class, 'index'])->name('public.home');

// Hero alternativo (opcional)
Route::get('/home2', [PublicController::class, 'home2'])->name('public.home2');

// Mostrar productos por subcategoría
Route::get('/categoria/{categorySlug}/{subcategorySlug}', [PublicController::class, 'showSubcategory'])
    ->name('public.subcategory.show');

// Detalle individual de producto
Route::get('/producto/{slug}', [PublicController::class, 'showProduct'])
    ->name('public.product.show');

// Vista general de productos (opcional)
Route::get('/productos', [PublicController::class, 'publicView'])
    ->name('public.products.index');

// Página de contacto
Route::get('/contacto', [ContactController::class, 'index'])->name('public.contact');
Route::post('/contacto', [ContactController::class, 'store'])->name('public.contact.store');


// Citas (frontend con FullCalendar)
Route::get('/citas', [CitaController::class, 'index'])->name('public.citas.index');
Route::post('/citas/guardar', [CitaController::class, 'store'])->name('public.citas.store');

// Días disponibles (para citas)
Route::get('/dias-disponibles', [DiaDisponibleController::class, 'index'])->name('public.dias.index');
Route::post('/dias-disponibles', [DiaDisponibleController::class, 'store'])->name('public.dias.store');


/*
|--------------------------------------------------------------------------
| ⚙️ RUTAS ADMINISTRATIVAS
|--------------------------------------------------------------------------
|
| Todas las rutas del panel de administración (dashboard).
| Aquí se recomienda aplicar un middleware de autenticación.
|
*/

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard principal
    Route::view('/', 'admin.dashboard')->name('dashboard');

    // HERO Section
    Route::get('/hero/edit', [HeroSectionController::class, 'edit'])->name('hero.edit');
    Route::post('/hero/update', [HeroSectionController::class, 'update'])->name('hero.update');

    // Categorías públicas
    Route::resource('categories', CategoryPublicController::class)->names('categories');

    // Subcategorías públicas
    Route::resource('subcategories', SubcategoryPublicController::class)->names('subcategories');

    // Productos públicos
    Route::resource('products', ProductPublicController::class)->names('products');

    // Productos destacados
    Route::get('/featured', [FeaturedProductController::class, 'index'])->name('featured.index');
    Route::post('/featured/store', [FeaturedProductController::class, 'store'])->name('featured.store');
    Route::put('/featured/{featured}/toggle', [FeaturedProductController::class, 'toggle'])->name('featured.toggle');
    Route::delete('/featured/{featured}', [FeaturedProductController::class, 'destroy'])->name('featured.destroy');
});


/*
|--------------------------------------------------------------------------
| 🚫 RUTA DE FALLBACK (404)
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
