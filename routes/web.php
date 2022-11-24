<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Controller::class, 'view'])->name('home')->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'view'])->name('profile.view');
        Route::post('/update-profile-information', [ProfileController::class, 'updateProfileInformation'])->name('profile.update-profile-information');
    });

    Route::group(['prefix' => '/user/documents', 'as' => 'user.documents.'], function () {
        Route::get('', [DocumentController::class, 'documents'])->name('table');
        Route::get('/download/template/{file}', [DocumentController::class, 'downloadTemplate'])->name('download.template');
        Route::get('/download/user_document/{file}', [DocumentController::class, 'downloadDocument'])->name('download.user-document');
        Route::post('/upload/{document_id}', [DocumentController::class, 'upload'])->name('upload');
        Route::get('/delete/{document_id}', [DocumentController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => '/address', 'as' => 'address.'], function () {
        Route::get('/create', [AddressController::class, 'create'])->name('create');
        Route::post('/create/post', [AddressController::class, 'createPost'])->name('create.post');
        Route::get('/all', [AddressController::class, 'all'])->name('all');
        Route::get('/{id}/edit', [AddressController::class, 'edit'])->name('edit');
        Route::post('/{id}/edit/post', [AddressController::class, 'editPost'])->name('edit.post');
        Route::get('/{id}/delete', [AddressController::class, 'delete'])->name('delete');
    });

    Route::group(['as' => 'order.', 'prefix' => '/order'], function () {
        Route::get('/all', [OrderController::class, 'tableView'])->name('all');
        Route::get('/create', [OrderController::class, 'createView'])->name('create')->middleware('if-ones-order-is-empty');
        Route::get('/create-order', [OrderController::class, 'createOrder'])->name('create-order')->middleware('if-ones-order-is-empty');
        Route::get('/{id}', [OrderController::class, 'viewOrder'])->name('view-order');
        Route::get('/{id}/edit', [OrderController::class, 'viewOrderEdit'])->name('view-order-edit');
        Route::post('/{id}/edit/post', [OrderController::class, 'orderEditPost'])->name('post-edit-order');
        Route::get('/{order_id}/delete', [OrderController::class, 'deleteOrder'])->name('delete');

        Route::group(['as' => 'product.'], function () {
            Route::get('/{id}/add-product', [OrderController::class, 'addProductView'])->name('add-product');
            Route::post('/{id}/add-product/create', [OrderController::class, 'addProductToOrder'])->name('add-product.create');
            Route::get('/{order_id}/product/{product_id}', [OrderController::class, 'viewProduct'])->name('view');
            Route::get('/{order_id}/product/{product_id}/edit', [OrderController::class, 'editProductView'])->name('edit');
            Route::post('/{order_id}/product/{product_id}/edit/post', [OrderController::class, 'editProductPost'])->name('edit.post');
            // delete product
            Route::get('/{order_id}/product/{product_id}/delete', [OrderController::class, 'deleteProduct'])->name('delete');
        });
    });

    Route::group(['prefix' => '/package', 'as' => 'package.'], function () {
        Route::get('/all', [PackageController::class, 'allPackages'])->name('all');
        Route::get('/create', [PackageController::class, 'createPackageView'])->name('create');
        Route::post('/create/post', [PackageController::class, 'createPackagePost'])->name('create.post');
        Route::get('/{id}', [PackageController::class, 'viewPackage'])->name('view');
        Route::get('/{id}/edit', [PackageController::class, 'editPackageView'])->name('edit');
        Route::post('/{id}/edit/post', [PackageController::class, 'editPackagePost'])->name('edit.post');

        Route::post('/{id}/add-order', [PackageController::class, 'addOrder'])->name('add-order');

        Route::get('/{id}/delete', [PackageController::class, 'deletePackage'])->name('delete');
    });

    Route::group(['prefix' => '/payment', 'as' => 'payment.'], function () {
        Route::get('/', [PaymentController::class, ''])->name('view');
    });
});

Route::get('/check_country', [Controller::class, 'checkCountry'])->name('check-country');



/////// ADMIN ////////
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [AdminController::class, 'MainView'])->name('main-view');

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [Admin\UserController::class, 'AllUsers'])->name('all-users');
        Route::get('/{id}/edit', [Admin\UserController::class, 'EditUser'])->name('edit');
        Route::get('/{id}/delete', [Admin\UserController::class, 'DeleteUser'])->name('delete');

        Route::get('/{id}/add-address', [Admin\UserController::class, 'AddAddressUser'])->name('add-address');
    });

    Route::group(['prefix' => '/shop', 'as' => 'shop.'], function () {
        Route::get('/all', [Admin\Order\Product\ShopController::class, 'viewAll'])->name('all');
        Route::get('/add', [Admin\Order\Product\ShopController::class, 'addShop'])->name('add');
        Route::post('/add/post', [Admin\Order\Product\ShopController::class, 'addShopPost'])->name('add.post');
        Route::get('/{id}/edit', [Admin\Order\Product\ShopController::class, 'editShop'])->name('edit');
        Route::post('/{id}/edit/post', [Admin\Order\Product\ShopController::class, 'editShopPost'])->name('edit.post');
        Route::get('/{id}/delete', [Admin\Order\Product\ShopController::class, 'deleteShop'])->name('delete');

        Route::post('/updateOrder', [Admin\Order\Product\ShopController::class, 'updateOrder'])->name('updateOrder');
    });

    Route::group(['prefix' => '/documents', 'as' => 'documents.'], function (){
        Route::get('', [Admin\DocumentController::class, 'all'])->name('all');
        Route::post('/updateOrder', [Admin\DocumentController::class, 'updateOrder'])->name('updateOrder');
        Route::get('/create', [Admin\DocumentController::class, 'createView'])->name('create');
        Route::post('/create/post', [Admin\DocumentController::class, 'create'])->name('create.post');
        Route::get('/{id}/edit', [Admin\DocumentController::class, 'editView'])->name('edit');
        Route::post('/{id}/edit/post', [Admin\DocumentController::class, 'edit'])->name('edit.post');
        Route::get('/{id}/delete', [Admin\DocumentController::class, 'delete'])->name('delete');
        Route::get('/{id}/delete/template', [Admin\DocumentController::class, 'deleteTemplate'])->name('delete.template');
        Route::get('/{id}/delete/example', [Admin\DocumentController::class, 'deleteExample'])->name('delete.example');

        // ДОДЕЛАТЬ
        Route::group(['prefix' => '/check', 'as' => 'check.'], function () {
            Route::get('/', [Admin\DocumentController::class, 'checkView'])->name('view');
        });
    });
});


require __DIR__ . '/auth.php';
