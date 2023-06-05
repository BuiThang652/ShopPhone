<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SingleProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Khách

Route::controller(HomeController::class)->group(function () {
    Route::get('/','show')->name('frontend.home');
    Route::get('/home/{id}', 'order')->name('frontend.home.order');

});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products','show')->name('frontend.products');
    Route::get('/products/{id}', 'order')->name('frontend.products.order');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/category','show')->name('frontend.category');
    Route::get('/category/{id}', 'order')->name('frontend.category.order');
});

Route::controller(ContactController::class)->group(function () {
    Route::get('/contact','show')->name('frontend.contact');
});

Route::controller(CartController::class)->group(function () {
    Route::middleware(['checkacl:user'])->group(function () {
        Route::get('/cart','show')->name('frontend.orders');
        Route::get('/cart/delete/{id}','delete')->name('frontend.orders.delete');
        Route::get('/cart/add/{id}','add')->name('frontend.orders.add');
        Route::get('/cart/remove/{id}','remove')->name('frontend.orders.remove');
        Route::post('/cart','order')->name('frontend.orders.order');
    });
});

Route::controller(SingleProductController::class)->group(function () {
    Route::get('/single-product/{id}','show')->name('frontend.single-product');
    Route::get('/single-product/order/{id}','order')->name('frontend.single-product.order');
    Route::post('/single-product/{id}','cart')->name('frontend.single-product.cart');
});


Route::prefix('admin')->group(function () {
    // Trang dashboard
    Route::controller(AdminDashboardController::class)->group(function () {
        Route::get('/dashboard','show')->name('admin.dashboard')->middleware('checkacl:dashboard');
    });

    // Trang quản lí tài khoản
    Route::controller(AdminUserController::class)->group(function () {
        Route::get('/user','show')->name('admin.user.show')->middleware('checkacl:list-user');
        
        Route::middleware(['checkacl:add-user'])->group(function () {
            Route::get('/user/create','create')->name('admin.user.create');
            Route::post('/user/create','store')->name('admin.user.store');
        });
        
        Route::middleware(['checkacl:edit-user'])->group(function () {
            Route::get('/user/edit/{id}','edit')->name('admin.user.edit');
            Route::post('/user/edit/{id}','update')->name('admin.user.update');
        });

        Route::middleware(['checkacl:delete-user'])->group(function () {
            Route::get('/user/delete/{id}','delete')->name('admin.user.delete');
        });
    });

    // Trang quản lí vai trò
    Route::controller(AdminRoleController::class)->group(function () {
        Route::get('/role','show')->name('admin.role.show')->middleware('checkacl:list-role');
        
        Route::middleware(['checkacl:add-role'])->group(function () {
            Route::get('/role/create','create')->name('admin.role.create');
            Route::post('/role/create','store')->name('admin.role.store');
        });

        Route::middleware(['checkacl:edit-role'])->group(function () {
            Route::get('/role/edit/{id}','edit')->name('admin.role.edit');
            Route::post('/role/edit/{id}','update')->name('admin.role.update');
        });

        Route::middleware(['checkacl:delete-role'])->group(function () {
            Route::get('/role/delete/{id}','delete')->name('admin.role.delete');
        });
    });

    // Quản lí category
    Route::controller(AdminCategoryController::class)->group(function () {
        Route::middleware(['checkacl:list-category'])->group(function () {
            Route::get('/category','show')->name('admin.category.show');
        });

        Route::middleware(['checkacl:add-category'])->group(function () {
            Route::get('/category/create','create')->name('admin.category.create');
            Route::post('/category/create','store')->name('admin.category.store');
        });

        Route::middleware(['checkacl:edit-category'])->group(function () {
            Route::get('/category/edit/{id}','edit')->name('admin.category.edit');
            Route::post('/category/edit/{id}','update')->name('admin.category.update');
        });

        Route::middleware(['checkacl:delete-category'])->group(function () {
            Route::get('/category/delete/{id}','delete')->name('admin.category.delete');
        });
    });

    // 
    Route::controller(AdminProductsController::class)->group(function () {
        Route::middleware(['checkacl:list-product'])->group(function () {
            Route::get('/product','show')->name('admin.product.show');
        });

        Route::middleware(['checkacl:add-product'])->group(function () {
            Route::get('/product/create','create')->name('admin.product.create');
            Route::post('/product/create','store')->name('admin.product.store');
        });

        Route::middleware(['checkacl:edit-product'])->group(function () {
            Route::get('/product/edit/{id}','edit')->name('admin.product.edit');
            Route::post('/product/edit/{id}','update')->name('admin.product.update');
        });

        Route::middleware(['checkacl:delete-product'])->group(function () {
            Route::get('/product/delete/{id}','delete')->name('admin.product.delete');
        });
    });
});

Route::middleware(['auth','checkacl:done'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';