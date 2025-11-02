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
use App\Http\Controllers\Auth\LoginController;



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

// Página de Promociones públicas
Route::get('/promociones', function () {
    return view('public.promociones');
})->name('public.promociones');

// Página de contacto pública
Route::get('/contacto', [ContactController::class, 'index'])->name('public.contact.index');
Route::post('/contacto', [ContactController::class, 'store'])->name('public.contact.store');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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
| Se recomienda protegerlas con middleware de autenticación.
|
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // 🏠 Dashboard principal
    Route::view('/', 'admin.dashboard')->name('dashboard');

    // 🎯 HERO Section
    Route::get('/hero/edit', [HeroSectionController::class, 'edit'])->name('hero.edit');
    Route::post('/hero/update', [HeroSectionController::class, 'update'])->name('hero.update');

    // 🧩 Categorías públicas
    Route::resource('categoriespublic', CategoryPublicController::class)->names('categoriespublic');

    // 🪪 Subcategorías públicas
    Route::resource('subcategoriespublic', SubcategoryPublicController::class)->names('subcategoriespublic');

    // 📦 Productos públicos
    Route::put('/productspublic/{productpublic}/toggle', [ProductPublicController::class, 'togglePublish'])
        ->name('productspublic.toggle');
    Route::resource('productspublic', ProductPublicController::class)->names('productspublic');
Route::delete('/productspublic/{productpublic}', [ProductPublicController::class, 'destroy'])
    ->name('productspublic.destroy');
Route::post('/productspublic/{productpublic}/delete', [ProductPublicController::class, 'destroy'])
    ->name('productspublic.delete');
    // ⭐ Productos destacados
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
