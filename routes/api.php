<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('api.login');
    Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('api.register');
    Route::get('logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('api.logout');
    // Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('api.logout');
    Route::post('refresh', [App\Http\Controllers\Api\AuthController::class, 'refreshToken'])->name('api.refresh');
    Route::middleware('auth:api')->get('me', [App\Http\Controllers\Api\AuthController::class, 'getUser'])->name('api.me');
});

Route::group(['prefix' => 'product'], function () {
    Route::get('list', [App\Http\Controllers\Api\ProductController::class, 'list'])->name('api.product.list');
    Route::get('detail/{slug}', [App\Http\Controllers\Api\ProductController::class, 'detail'])->name('api.product.detail');
    Route::get('latest', [App\Http\Controllers\Api\ProductController::class, 'latestProduct'])->name('api.product.latest');
    Route::get('selected', [App\Http\Controllers\Api\ProductController::class, 'selectedProduct'])->name('api.product.selected');
});

Route::group(['prefix' => 'category'], function () {
    Route::get('list', [App\Http\Controllers\Api\CategoryController::class, 'getCategories'])->name('api.category.list');
});

// cart
Route::group(['prefix' => 'cart'], function () {
    Route::post('add', [App\Http\Controllers\Api\CartController::class, 'addToCart'])->name('api.cart.add');
    Route::get('list', [App\Http\Controllers\Api\CartController::class, 'list'])->name('api.cart.list');
    Route::get('summary', [App\Http\Controllers\Api\CartController::class, 'cartSummary'])->name('api.cart.summary');
    Route::delete('delete/{id}', [App\Http\Controllers\Api\CartController::class, 'removeCart'])->name('api.cart.delete');
    Route::post('update/{id}', [App\Http\Controllers\Api\CartController::class, 'updateCart'])->name('api.cart.update');
});

// address
Route::group(['prefix' => 'address'], function () {
    Route::get('defaultAddress', [App\Http\Controllers\Api\AddressController::class, 'getDefaultAddress'])->name('api.address.getDefaultAddress');
    Route::get('listAddress', [App\Http\Controllers\Api\AddressController::class, 'listAddress'])->name('api.address.list');
    Route::post('setDefault/{id}', [App\Http\Controllers\Api\AddressController::class, 'setDefault'])->name('api.address.setDefault');
    Route::post('addAddress', [App\Http\Controllers\Api\AddressController::class, 'addAddress'])->name('api.address.add');
    Route::post('update/{id}', [App\Http\Controllers\Api\AddressController::class, 'updateAddress'])->name('api.address.update');
    Route::delete('delete/{id}', [App\Http\Controllers\Api\AddressController::class, 'deleteAddress'])->name('api.address.delete');
    Route::get('detail/{id}', [App\Http\Controllers\Api\AddressController::class, 'detailAddress'])->name('api.address.detail');
});

// order
Route::group(['prefix' => 'checkout'], function () {
    Route::post('getOngkir', [App\Http\Controllers\Api\CheckoutController::class, 'getOngkir'])->name('api.checkout.ongkir');
    Route::post('/', [App\Http\Controllers\Api\CheckoutController::class, 'checkout'])->name('api.checkout.store');
    Route::post('/notification', [App\Http\Controllers\Api\HandlerMidtransController::class, 'index'])->name('api.checkout.notification');
});

// transaction
Route::group(['prefix' => 'transaction'], function () {
    Route::get('list', [App\Http\Controllers\Api\TransactionController::class, 'listTransaction'])->name('api.transaction.list');
    Route::get('detail/{id}', [App\Http\Controllers\Api\TransactionController::class, 'detailTransaction'])->name('api.transaction.detail');
    // Route::post('cancel/{id}', [App\Http\Controllers\Api\TransactionController::class, 'cancel'])->name('api.transaction.cancel');
});

Route::prefix('region')->group(function () {
    Route::get('/provinces', [App\Http\Controllers\Api\RegionController::class, 'getProvincies'])->name('api.region.provinces');
    Route::get('/cities/{id}', [App\Http\Controllers\Api\RegionController::class, 'getCities'])->name('api.region.cities');
    Route::get('/subdistricts/{id}', [App\Http\Controllers\Api\RegionController::class, 'getSubdistricts'])->name('api.region.subdistricts');
});

Route::prefix('wishlist')->group(function () {
    Route::post('/', [App\Http\Controllers\Api\WishlistController::class, 'wishlist'])->name('api.wishlist.wishlist');
    Route::get('/list', [App\Http\Controllers\Api\WishlistController::class, 'list'])->name('api.wishlist.list');
    Route::get('/status/{slug}', [App\Http\Controllers\Api\WishlistController::class, 'getWishlistStatus'])->name('api.wishlist.getWishlistStatus');
});

Route::get('/tracking/{id}', [App\Http\Controllers\Api\TrackingController::class, 'tracking'])->name('api.tracking.lacak');

Route::prefix('profile')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\ProfileController::class, 'index'])->name('api.profile.index');
    Route::post('/update', [App\Http\Controllers\Api\ProfileController::class, 'updateProfile'])->name('api.profile.update');
    Route::post('/update-photo', [App\Http\Controllers\Api\ProfileController::class, 'updatePhoto'])->name('api.profile.update-photo');
    Route::post('/update-password', [App\Http\Controllers\Api\ProfileController::class, 'updatePassword'])->name('api.profile.update-password');
    Route::post('/check-username', [App\Http\Controllers\Api\ProfileController::class, 'checkUsername'])->name('api.profile.check-username');
    Route::post('/check-email', [App\Http\Controllers\Api\ProfileController::class, 'checkEmail'])->name('api.profile.check-email');
    Route::post('/check-phone', [App\Http\Controllers\Api\ProfileController::class, 'checkPhone'])->name('api.profile.check-phone');
});

Route::post('review', [App\Http\Controllers\Api\ReviewController::class, 'review'])->name('api.review.store');
Route::get('review', [App\Http\Controllers\Api\ReviewController::class, 'list'])->name('api.review.listReview');
Route::get('review/{id}', [App\Http\Controllers\Api\ReviewController::class, 'getReviewByOrder'])->name('api.review.detailReview');

Route::prefix('expert-system')
    ->name('api.expert-system.')
    ->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::get('/pest-diseases', [App\Http\Controllers\Admin\PestDiseaseController::class, 'index'])->name('pest-diseases');
            Route::get('/symptoms', [App\Http\Controllers\Admin\SymptomsController::class, 'index'])->name('symptoms');
            Route::post('/diagnose', [App\Http\Controllers\Api\ExpertSystemController::class, 'postDiagnostic'])->name('diagnose');
            Route::post('/logout', [App\Http\Controllers\Api\ExpertSystemController::class, 'logout'])->name('logout');
            Route::get('/diagnose-list', [App\Http\Controllers\Api\ExpertSystemController::class, 'getDiagnoseList'])->name('diagnose-list');
            Route::get('/diagnose-detail/{id}', [App\Http\Controllers\Api\ExpertSystemController::class, 'getDiagnoseById'])->name('diagnose-detail');
            Route::post('/diagnose-add-day', [App\Http\Controllers\Api\ExpertSystemController::class, 'addDaysTreatment'])->name('diagnose-add-day');
            Route::get('/user', [App\Http\Controllers\Api\ExpertSystemController::class, 'getProfile'])->name('user');
            Route::put('/user', [App\Http\Controllers\Api\ExpertSystemController::class, 'updateProfile'])->name('user-update');
        });

        Route::post('/check-email', [App\Http\Controllers\Api\ExpertSystemController::class, 'checkEmail'])->name('check-email');
        Route::post('/login', [App\Http\Controllers\Api\ExpertSystemController::class, 'login'])->name('login');
        Route::post('/register', [App\Http\Controllers\Api\ExpertSystemController::class, 'register'])->name('register');
    });
