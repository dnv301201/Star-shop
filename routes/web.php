<?php

use App\Http\Controllers\Admin\AdminOderController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\User\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\UserLoginController;
use App\Http\Controllers\User\UserRegisterController;
use App\Http\Controllers\User\ProOfCateController;
use App\Http\Controllers\User\ProductDetailController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\OderController;
use App\Http\Controllers\User\ProductOfCateController;
use App\Http\Controllers\Admin\StatiticsController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['web'])->group(function () {

    //-------------Xử lý User

    Route::get('/',[HomeController::class,'index'])->name('users.index');
    
    Route::get('/product_detail/{id}',[ProductDetailController::class,'product_detail'])->name('product_detail');
    
    Route::get('/login',[UserLoginController::class, 'index'])->name('user.login');

    Route::post('/login/store',[UserLoginController::class, 'store'])->name('user.login.store');
    
    Route::get('/register',[UserRegisterController::class, 'index'])->name('user.register');
    
    Route::post('/register',[UserRegisterController::class, 'register'])->name('register.store');

    Route::post('/logout',[UserLoginController::class, 'logout'])->name('user.logout')->middleware('auth');

    Route::get('/category/{categorySlug}', [HomeController::class, 'showCategory'])->name('category.show');

    Route::get('/search', [HomeController::class, 'search'])->name('search');

    Route::get('/category/{id}/child/{childId}', [ProductOfCateController::class,'showChild'])->name('category.showChild');
    
    Route::prefix('user')->middleware('auth')->group(function(){
        Route::post('/add-to-cart',[CartController::class, 'addToCart'])->name('cart.add');

        Route::get('/cart-view',[CartController::class, 'viewCart'])->name('cart.view');

        Route::post('/cart-update/{productId}/{color}/{size}',[CartController::class, 'updateCartQuantity'])->name('cart.update');

        Route::get('/cart/remove/{productId}/{color}/{size}', [CartController::class, 'removeProduct'])->name('cart.removeProduct');

        Route::post('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

        Route::post('/process_checkout',[OderController::class,'processCheckout'])->name('process.checkout');

        
        Route::get('/order_response',[OderController::class,'oderes_Page'])->name('order.response');

        // Route::post('/order_response', [OderController::class, 'orderResponse'])->name('order.response.post');

        Route::get('/order_user/{id}',[OderController::class,'show_Order'])->name('user.order.show');



    });



    // ----------Xử Lý Admin----------------

    Route::get('/admin/login',[LoginController::class, 'index'])->name('admin.login');
    Route::post('admin/login/store',[LoginController::class, 'store'])->name('admin.login.store');

    Route::prefix('admin')->middleware(['admin'])->group(function ()
    {
        // Route::get('/home',function(){return view('admin.home');})->name('admin.home');



        Route::get('/home', [StatiticsController::class, 'index'])->name('admin.home');


        Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class,'index'])->name('category.index');
            Route::get('/create', [CategoryController::class,'create'])->name('category.create');
            Route::post('/store',[CategoryController::class,'store'])->name('category.store');
        
            Route::get('/edit/{id}', [CategoryController::class,'edit'])->name('category.edit');
        
            Route::post('/update/{id}', [CategoryController::class,'update'])->name('category.update');
        
            Route::get('/delete/{id}', [CategoryController::class,'delete'])->name('category.delete');
        });
        
        
        //product
        Route::prefix('product')->group(function () {
            Route::get('/', [AdminProductController::class,'index'])->name('product.index');

            Route::get('/create', [AdminProductController::class,'create'])->name('product.create');
            Route::post('/store', [AdminProductController::class,'store'])->name('product.store');

            Route::get('/view/{id}', [AdminProductController::class,'view'])->name('product.view');

            Route::get('/edit/{id}', [AdminProductController::class,'edit'])->name('product.edit');
        
            Route::post('/update/{id}', [AdminProductController::class,'update'])->name('product.update');
        
            Route::get('/delete/{id}', [AdminProductController::class,'delete'])->name('product.delete');
            
            Route::get('/view/{id}', [AdminProductController::class,'view'])->name('product.view');

            Route::get('/product/{id}/add-version', [AdminProductController::class,'showAddProductVersionForm'])->name('product.addProductVersion');
            Route::post('/product/{id}/add-version', [AdminProductController::class, 'storeProductVersion'])->name('product.storeProductVersion');

            Route::get('/search', [AdminProductController::class,'search'])->name('product.search');
        });
        Route::prefix('order')->group(function () {
            Route::get('/', [AdminOderController::class,'index'])->name('order.index');
        });
        Route::group(['prefix' => 'laravel-filemanager', 'middleware'], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });
    });

    //  Route::prefix('staff')->middleware('staff')->group(function () {
    //     Route::get('/home',function(){return view('admin.home');})->name('admin.home');
    //     Route::get('/', [AdminProductController::class,'index'])->name('product.index');

    //     Route::get('/create', [AdminProductController::class,'create'])->name('product.create');
    //     Route::post('/store', [AdminProductController::class,'store'])->name('product.store');

    //     Route::get('/view/{id}', [AdminProductController::class,'view'])->name('product.view');

    //     Route::get('/edit/{id}', [AdminProductController::class,'edit'])->name('product.edit');
    
    //     Route::post('/update/{id}', [AdminProductController::class,'update'])->name('product.update');
    
    //     Route::get('/delete/{id}', [AdminProductController::class,'delete'])->name('product.delete');
        
    //     Route::get('/view/{id}', [AdminProductController::class,'view'])->name('product.view');

    //     Route::get('/product/{id}/add-version', [AdminProductController::class,'showAddProductVersionForm'])->name('product.addProductVersion');
    //     Route::post('/product/{id}/add-version', [AdminProductController::class, 'storeProductVersion'])->name('product.storeProductVersion');

    //     Route::get('/search', [AdminProductController::class,'search'])->name('product.search');
    //     Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
    // });


});


// Route::get('/user/login',[SingupController::class, 'index'])->name('user.login');






// categories
