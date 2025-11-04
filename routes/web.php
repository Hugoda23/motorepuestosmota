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
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;

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
Route::get('/promociones', [PublicController::class, 'promociones'])
    ->name('public.promociones');

// Página de contacto pública
Route::get('/contacto', [ContactController::class, 'index'])->name('public.contact.index');
Route::post('/contacto', [ContactController::class, 'store'])->name('public.contact.store');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ⚙️ RUTAS ADMINISTRATIVAS (Panel protegido con login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // 🏠 Dashboard principal
    Route::view('/', 'admin.dashboard')->name('dashboard');

    // 👥 Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::post('/usuarios/store', [UserController::class, 'store'])->name('users.store');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');

 // Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');



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

    // ⭐ Productos destacados
    Route::get('/featured', [FeaturedProductController::class, 'index'])->name('featured.index');
    Route::post('/featured/store', [FeaturedProductController::class, 'store'])->name('featured.store');
    Route::put('/featured/{featured}/toggle', [FeaturedProductController::class, 'toggle'])->name('featured.toggle');
    Route::delete('/featured/{featured}', [FeaturedProductController::class, 'destroy'])->name('featured.destroy');

    // 🏷️ Promociones
    Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
    Route::post('/promotions/store', [PromotionController::class, 'store'])->name('promotions.store');
    Route::put('/promotions/{promotion}/toggle', [PromotionController::class, 'toggle'])->name('promotions.toggle');
    Route::delete('/promotions/{promotion}', [PromotionController::class, 'destroy'])->name('promotions.destroy');

    // 📅 Citas
    Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
    Route::get('/citas/get', [CitaController::class, 'getCitas'])->name('citas.get');
    Route::post('/citas/store', [CitaController::class, 'store'])->name('citas.store');
    Route::post('/citas/actualizar', [CitaController::class, 'actualizar'])->name('citas.actualizar');
    Route::post('/citas/eliminar/{id}', [CitaController::class, 'eliminar'])->name('citas.eliminar');

    // 🗓️ Días disponibles
    Route::get('/dias-disponibles', [DiaDisponibleController::class, 'index'])->name('dias-disponibles.index');
    Route::post('/dias-disponibles/store', [DiaDisponibleController::class, 'store'])->name('dias-disponibles.store');
    Route::put('/dias-disponibles/{id}', [DiaDisponibleController::class, 'update'])->name('dias-disponibles.update');
    Route::delete('/dias-disponibles/{id}', [DiaDisponibleController::class, 'destroy'])->name('dias-disponibles.destroy');
    Route::get('/dias/llenos', [DiaDisponibleController::class, 'diasLlenos'])->name('dias.llenos');
});


/*
|--------------------------------------------------------------------------
| 🚫 RUTA DE FALLBACK (404)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
