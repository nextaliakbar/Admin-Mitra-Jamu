<?php

use App\Http\Controllers\TemporaryFileController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'auth'], function () {
  Route::get('/', function () {
    return redirect()->route('root');
  });
  Route::prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');


    Route::resource('/products', App\Http\Controllers\Admin\ProductController::class, ['as' => 'admin']);

    Route::resource('/forecasting', App\Http\Controllers\Admin\ForecastController::class, ['as' => 'admin']);
    Route::post('/forecasting/chart', [App\Http\Controllers\Admin\ForecastController::class, 'chart'])->name('admin.forecasting.chart');
    Route::post('/forecasting/table', [App\Http\Controllers\Admin\ForecastController::class, 'table'])->name('admin.forecasting.table');
    Route::post('/forecasting/count', [App\Http\Controllers\Admin\ForecastController::class, 'count'])->name('admin.forecasting.count');

    Route::get('/products-list', [App\Http\Controllers\Admin\ProductController::class, 'list'])->name('admin.products.list');

    Route::resource('/categories', App\Http\Controllers\Admin\ProductCategoryController::class, ['as' => 'admin']);
    Route::resource('/labels', App\Http\Controllers\Admin\ProductLabelController::class, ['as' => 'admin']);

    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{id}/update-status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::post('/orders/{id}/add-receipt', [App\Http\Controllers\Admin\OrderController::class, 'addReceipt'])->name('admin.orders.addReceipt');
    Route::post('/orders/{id}/invoice', [App\Http\Controllers\Admin\OrderController::class, 'invoice'])->name('admin.orders.invoice');
    Route::get('/orders/{id}/tracking', [App\Http\Controllers\Admin\OrderController::class, 'tracking'])->name('admin.orders.tracking');

    Route::resource('/suppliers', App\Http\Controllers\Admin\SupplierController::class, ['as' => 'admin']);
    Route::get('/get-suppliers', [App\Http\Controllers\Admin\SupplierController::class, 'getSuppliers'])->name('admin.suppliers.getSuppliers');
    Route::get('/get-products', [App\Http\Controllers\Admin\ProductController::class, 'getProducts'])->name('admin.products.getProducts');
    Route::resource('/purchases', App\Http\Controllers\Admin\PurchaseController::class, ['as' => 'admin']);

    Route::resource('/vouchers', App\Http\Controllers\Admin\VoucherController::class, ['as' => 'admin']);


    Route::resource('/users', App\Http\Controllers\Admin\UserController::class, ['as' => 'admin']);
    Route::resource('/customers', App\Http\Controllers\Admin\CustomerController::class, ['as' => 'admin']);
    Route::resource('/roles', App\Http\Controllers\Admin\RoleController::class, ['as' => 'admin']);
    Route::resource('/permissions', App\Http\Controllers\Admin\PermissionController::class, ['as' => 'admin']);

    //Master Data
    Route::resource('/employment', App\Http\Controllers\Admin\EmploymentController::class, ['as' => 'admin']);
    Route::resource('/employee', App\Http\Controllers\Admin\EmployeeController::class, ['as' => 'admin']);
    Route::resource('/member', App\Http\Controllers\Admin\MemberController::class, ['as' => 'admin']);
    Route::resource('/asset', App\Http\Controllers\Admin\AssetController::class, ['as' => 'admin']);

    Route::get('/cashier', [App\Http\Controllers\Admin\CashierController::class, 'index'])->name('admin.cashier.index');
    Route::post('/cashier', [App\Http\Controllers\Admin\CashierController::class, 'store'])->name('admin.cashier.store');
    Route::get('/cashier/{id}', [App\Http\Controllers\Admin\CashierController::class, 'invoice'])->name('admin.cashier.invoice');
    Route::get('/getBarangData', [App\Http\Controllers\Admin\CashierController::class, 'product_data'])->name('admin.cashier.product_data');
    Route::get('/register_pos', [App\Http\Controllers\Admin\CashierRegisterController::class, 'index'])->name('admin.pos.register');
    Route::get('/close_pos', [App\Http\Controllers\Admin\CashierController::class, 'close'])->name('admin.pos.close');
    Route::get('/close_cashier', [App\Http\Controllers\Admin\CashierController::class, 'close_cashier'])->name('admin.pos.close_cashier');
    Route::post('/register_pos', [App\Http\Controllers\Admin\CashierRegisterController::class, 'store'])->name('admin.pos.store');


    //Accounting
    Route::resource('/salary-payment', App\Http\Controllers\Admin\SalaryPaymentController::class, ['as' => 'admin']);
    Route::get('/getDetail/{id}', [App\Http\Controllers\Admin\SalaryPaymentController::class, 'get_detail'])->name('admin.salary-payment.get_detail');

    Route::get('/slip', function () {
      return view('pages._Main.Accounting.SalaryPayment.slip');
    })->name('admin.salary-payment.slip');

    Route::get('/slip-kasir', function () {
      return view('pages._Main.Cashier.slip');
    })->name('admin.cashier.slip');

    Route::name('admin.debts.')->group(function () {
      Route::get('/debts', [App\Http\Controllers\Admin\DebtController::class, 'index'])->name('index');
      Route::put('/debts/{id}', [App\Http\Controllers\Admin\DebtController::class, 'update'])->name('update');
      Route::get('/debts/{id}/edit', [App\Http\Controllers\Admin\DebtController::class, 'edit'])->name('edit');
    });

    Route::name('admin.receivables.')->group(function () {
      Route::get('/receivables', [App\Http\Controllers\Admin\ReceivableController::class, 'index'])->name('index');
      Route::put('/receivables/{id}', [App\Http\Controllers\Admin\ReceivableController::class, 'update'])->name('update');
      Route::get('/receivables/{id}/edit', [App\Http\Controllers\Admin\ReceivableController::class, 'edit'])->name('edit');
    });

    // Route::name('admin.report.')->group(function () {
    //   Route::get('/report', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.report.index');
    // });
    Route::get('/report', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.report.index');

    Route::get('/cash', [App\Http\Controllers\Admin\CashFlowController::class, 'index'])->name('admin.cash.index');

    // Route::get('/report', function () {
    //   return view('pages._Main.Accounting.Report.index');
    // })->name('admin.report.index');

    Route::get('/balance', [App\Http\Controllers\Admin\BalanceController::class, 'index'])->name('admin.balance.index');

    Route::get('/profit_loss', [App\Http\Controllers\Admin\ProfitLossController::class, 'index'])->name('admin.profit-loss.index');


    //filepond route
    Route::post('/upload', [TemporaryFileController::class, 'store'])->name('filepond.upload');
    Route::delete('/revert', [TemporaryFileController::class, 'destroy'])->name('filepond.revert');

    Route::prefix('regions')->group(function () {
      Route::get('/provinces', [App\Http\Controllers\RegionController::class, 'getProvince'])->name('admin.regions.provinces');
      Route::get('/cities/{province_id}', [App\Http\Controllers\RegionController::class, 'getCity'])->name('admin.regions.cities');
      Route::get('/subdistricts/{city_id}', [App\Http\Controllers\RegionController::class, 'getSubdistrict'])->name('admin.regions.subdistricts');
    });

    // Expert System
    Route::resource('/pest-diseases', App\Http\Controllers\Admin\PestDiseaseController::class, ['as' => 'admin']);
    Route::resource('/symptoms', App\Http\Controllers\Admin\SymptomsController::class, ['as' => 'admin']);
    Route::resource('/rules', App\Http\Controllers\Admin\RuleController::class, ['as' => 'admin']);
    Route::name('admin.conditions.')->group(function () {
      Route::get('/conditions', [App\Http\Controllers\Admin\ConditionController::class, 'index'])->name('index');
      Route::get('/conditions/{id}/edit', [App\Http\Controllers\Admin\ConditionController::class, 'edit'])->name('edit');
      Route::get('/conditions/{id}', [App\Http\Controllers\Admin\ConditionController::class, 'show'])->name('show');
      Route::put('/conditions/{id}', [App\Http\Controllers\Admin\ConditionController::class, 'update'])->name('update');
      Route::delete('/conditions/{id}', [App\Http\Controllers\Admin\ConditionController::class, 'destroy'])->name('destroy');
      Route::get('/conditions/create/{pest_disease_id}', [App\Http\Controllers\Admin\ConditionController::class, 'create'])->name('create');
      Route::post('/conditions', [App\Http\Controllers\Admin\ConditionController::class, 'store'])->name('store');
    });
    Route::get('history-diagnose', [App\Http\Controllers\Admin\RuleController::class, 'history'])->name('admin.diagnoses.history');

    Route::get('/test', function () {
      return view('test');
    })->name('admin.test.index');

    Route::get('/custom-transaction', [App\Http\Controllers\CustomTransactionController::class, 'index'])->name('admin.custom-transaction.index');
    Route::put('/custom-transaction/{id}', [App\Http\Controllers\CustomTransactionController::class, 'update'])->name('admin.custom-transaction.update');
    Route::post('/custom-transaction', [App\Http\Controllers\CustomTransactionController::class, 'store'])->name('admin.custom-transaction.store');
    Route::get('/custom-transaction/{id}/edit', [App\Http\Controllers\CustomTransactionController::class, 'edit'])->name('admin.custom-transaction.edit');
    Route::delete('/custom-transaction/{id}', [App\Http\Controllers\CustomTransactionController::class, 'destroy'])->name('admin.custom-transaction.destroy');

    // =========== CMS =========== //
    Route::resource('/slider', App\Http\Controllers\Admin\SliderController::class, ['as' => 'admin']);
    Route::resource('/faq', App\Http\Controllers\Admin\FaqController::class, ['as' => 'admin']);
    Route::resource('/privacy-policy', App\Http\Controllers\Admin\PrivacyPolicyController::class, ['as' => 'admin']);
    Route::resource('/terms-and-conditions', App\Http\Controllers\Admin\TermsConditionsController::class, ['as' => 'admin']);
    Route::resource('/contact-us', App\Http\Controllers\Admin\ContactUsController::class, ['as' => 'admin']);
    Route::resource('/about-us', App\Http\Controllers\Admin\AboutUsController::class, ['as' => 'admin']);
    Route::resource('/product-highlights', App\Http\Controllers\Admin\ProductHighlightController::class, ['as' => 'admin']);
    Route::resource('/product-highlight-categories', App\Http\Controllers\Admin\ProductHighlightCategoryController::class, ['as' => 'admin']);
  });
});
Route::get('admin/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// abort 404
Route::fallback(function () {
  return abort(404);
});
