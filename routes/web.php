<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MoneyTransferController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StockCountController;
use App\Http\Controllers\SubscriptionPurchaseController;
use App\Http\Controllers\SuperAdmin\PaymentGatewayController;
use App\Http\Controllers\SuperAdmin\SubscriptionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth
Route::controller(LoginController::class)->middleware('guest')->group(function () {
    Route::get('/signin', 'index')->name('signin.index');
    Route::get('/signup', 'signup')->name('signup.index');
    Route::post('/signup/request', 'signupRequest')->name('signup.request');
    Route::post('/signin', 'signin')->name('signin.request');
    Route::get('/signup/varification/{token}', 'varification')->name('signup.varification');
});
Route::middleware(['auth', 'check_permission'])->group(function () {
    Route::get('/signout', [LoginController::class, 'logout'])->middleware('auth')->name('signout');
    Route::get('/', [DashboardController::class, 'index'])->name('root');
    //subscriptions
    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('subscriptions', 'index')->name('subscription.index');
        Route::get('subscription/status-chanage/{subscription}/{status}', 'statusChanage')->name('subscription.status.chanage');
        Route::post('subscription/store', 'store')->name('subscription.store');
        Route::put('subscription/update/{subscription}', 'update')->name('subscription.update');
        Route::get('subscription/requests', 'requests')->name('subscription.requests');
        Route::put('subscription/status-update', 'statusUpdate')->name('subscription.status.update');
    });
    // Unit
    Route::controller(SubscriptionPurchaseController::class)->group(function () {
        Route::get('subscription-purchase', 'index')->name('subscription-purchase.index');
        Route::get('subscription-purchase/update/{subscription}', 'update')->name('subscription-purchase.update');
    });
     // Payment Gateway
     Route::controller(PaymentGatewayController::class)->group(function () {
        Route::get('payment-gateways', 'index')->name('payment-gateway.index');
        Route::put('payment-gateway/update/{paymentGateway}', 'update')->name('payment-gateway.update');
    });
    //Role Permissions
    Route::controller(RoleController::class)->group(function () {
        Route::get('role', 'index')->name('role.index');
        Route::post('role/store', 'store')->name('role.store');
        Route::put('role/update/{role}', 'update')->name('role.update');
        Route::get('role/permission/{id}', 'permission')->name('role.permission');
        Route::post('role/set-permission', 'setPermission')->name('role.setPermission');
    });
    // Unit
    Route::controller(UnitController::class)->group(function () {
        Route::get('unit', 'index')->name('unit.index');
        Route::post('unit/store', 'store')->name('unit.store');
        Route::post('unit/update/{unit}', 'update')->name('unit.update');
        Route::get('unit/delete/{unit}', 'delete')->name('unit.delete');
    });
    //Category
    Route::controller(CategoryController::class)->group(function () {
        Route::get('categories', 'index')->name('category.index');
        Route::post('category/store', 'store')->name('category.store');
        Route::put('category/update/{category}', 'update')->name('category.update');
        Route::get('category/delete/{category}', 'delete')->name('category.delete');
        Route::post('category/import', 'import')->name('category.import');
        Route::get('category/print', 'categoryPrint')->name('category.print');
        Route::get('download/sample', 'downloadSample')->name('download.sample');
    });
    //Brand
    Route::controller(BrandController::class)->group(function () {
        Route::get('brand', 'index')->name('brand.index');
        Route::post('brand/store', 'store')->name('brand.store');
        Route::post('brand/update/{brand}', 'update')->name('brand.update');
        Route::get('brand/delete/{brand}', 'delete')->name('brand.delete');
    });
    //Supplier
    Route::controller(SupplierController::class)->group(function () {
        Route::get('supplier', 'index')->name('supplier.index');
        Route::get('supplier/create', 'create')->name('supplier.create');
        Route::post('supplier/store', 'store')->name('supplier.store');
        Route::get('supplier/edit/{supplier}', 'edit')->name('supplier.edit');
        Route::put('supplier/update/{supplier}', 'update')->name('supplier.update');
        Route::get('supplier/destroy/{supplier}', 'destroy')->name('supplier.destroy');
        Route::post('supplier/import', 'import')->name('supplier.import');
        Route::get('download/supplier/sample', 'downloadSupplierSample')->name('download.supplier.sample');
    });
    //warehouse
    Route::controller(WarehouseController::class)->group(function () {
        Route::get('warehouse', 'index')->name('warehouse.index');
        Route::post('warehouse/store', 'store')->name('warehouse.store');
        Route::post('warehouse/update/{warehouse}', 'update')->name('warehouse.update');
        Route::get('warehouse/delete/{warehouse}', 'delete')->name('warehouse.delete');
    });
    //Tax
    Route::controller(TaxController::class)->group(function () {
        Route::get('tax', 'index')->name('tax.index');
        Route::post('tax/store', 'store')->name('tax.store');
        Route::post('tax/update/{tax}', 'update')->name('tax.update');
        Route::get('tax/delete/{tax}', 'delete')->name('tax.delete');
    });
    //Product
    Route::controller(ProductController::class)->group(function () {
        Route::get('products', 'index')->name('product.index');
        Route::get('product/create', 'create')->name('product.create');
        Route::post('product/store', 'store')->name('product.store');
        Route::get('product/edit/{product}', 'edit')->name('product.edit');
        Route::put('product/update/{product}', 'update')->name('product.update');
        Route::get('product/destroy/{product}', 'destroy')->name('product.destroy');
        Route::get('product/gencode', 'generateCode')->name('product.generate.code');
        Route::get('product/search', 'productSearch')->name('product.search');
        Route::get('product/item', 'productItem')->name('product.item');
        Route::post('product/barcode/generate', 'barcodeGenerate')->name('product.barcode.generate');
        Route::get('barcode-print', 'printBarcode')->name('barcode.print');
        Route::get('products/saleunit/', 'saleUnit')->name('product.saleUnit');
        Route::post('product/import', 'import')->name('product.import');
        Route::get('product/sample/download', 'productDownloadSample')->name('product.download.sample');
        Route::get('product/print', 'productPrint')->name('product.print');
    });
    //Customer
    Route::controller(CustomerController::class)->group(function () {
        Route::get('customer', 'index')->name('customer.index');
        Route::get('customer/create', 'create')->name('customer.create');
        Route::post('customer/store', 'store')->name('customer.store');
        Route::get('customer/edit/{customer}', 'edit')->name('customer.edit');
        Route::put('customer/update/{customer}', 'update')->name('customer.update');
        Route::get('customer/destroy/{customer}', 'destroy')->name('customer.destroy');
        Route::post('customer/import', 'import')->name('customer.import');
        Route::get('download/customer/sample', 'downloadCustomerSample')->name('download.customer.sample');
    });
    // Purchase
    Route::controller(PurchaseController::class)->group(function () {
        Route::get('purchase/list', 'index')->name('purchase.index');
        Route::get('purchase/create', 'create')->name('purchase.create');
        Route::post('purchase/store', 'store')->name('purchase.store');
        Route::get('purchase/edit/{purchase}', 'edit')->name('purchase.edit');
        Route::put('purchase/update/{purchase}', 'update')->name('purchase.update');
        Route::get('purchase/destroy/{purchase}', 'destroy')->name('purchase.destroy');
        Route::get('purchases/product/search', 'productSearch')->name('product_purchase.search');
        Route::get('purchases/product/item', 'productItem')->name('product_purchase.item');
        Route::post('purchases/add_payment/{id}', 'addPayment')->name('purchase.add-payment');
        Route::get('purchases/deletepayment/{payment}', 'deletePayment')->name('purchase.delete-payment');
        Route::get('purchase/batch', 'batch')->name('purchase.batch');
        Route::get('purchase/print', 'purchasePrint')->name('purchase.print');
    });
    //User
    Route::controller(UserController::class)->group(function () {
        Route::get('user', 'index')->name('user.index');
        Route::get('user/create', 'create')->name('user.create');
        Route::post('user/store', 'store')->name('user.store');
        Route::get('user/edit/{user}', 'edit')->name('user.edit');
        Route::put('user/update/{user}', 'update')->name('user.update');
        Route::get('user/delete/{user}', 'destroy')->name('user.delete');
        Route::get('user/profile/{user}', 'profile')->name('profile.index');
        Route::put('user/update-profile/{user}', 'profileUpdate')->name('profile.update');
        Route::post('user/changepass/{user}', 'changePassword')->name('user.password');
        Route::get('user/genpass', 'generatePassword')->name('genPassword');
    });
    //customer group
    Route::controller(CustomerGroupController::class)->group(function () {
        Route::get('customer-group', 'index')->name('customer_group.index');
        Route::post('customer-group/store', 'store')->name('customer_group.store');
        Route::post('customer-group/update/{customerGroup}', 'update')->name('customer_group.update');
        Route::get('customer-group/delete/{customerGroup}', 'delete')->name('customer_group.delete');
    });
    //Sales
    Route::controller(SaleController::class)->group(function () {
        Route::get('sales', 'index')->name('sale.index');
        Route::get('sales/draft', 'draft')->name('sale.draft');
        Route::get('sales/draft/delete/{sale}', 'draftDelete')->name('sale.draft.delete');
        Route::get('pos', 'posSale')->name('sale.pos');
        Route::get('sales/invoice/{id}', 'generateInvoice')->name('sale.invoice.generate');
        Route::get('sale/print', 'salePrint')->name('sale.print');
    });
    //Stock Count
    Route::controller(StockCountController::class)->group(function () {
        Route::get('stock/count', 'index')->name('stockCount.index');
        Route::post('stock/count/store', 'store')->name('stockCount.store');
    });
    //Report
    Route::controller(ReportController::class)->group(function () {
        Route::get('report/summary', 'summary')->name('report.summary');
    });
    //Sale Returns
    Route::controller(SaleReturnController::class)->group(function () {
        Route::get('sale-returns', 'index')->name('sale_returns.index');
        Route::post('sale-returns/search', 'search')->name('sale_returns.search');
        Route::get('sale-returns/details/{sale}', 'details')->name('sale_returns.details');
        Route::post('sale-return/product/store/{sale}', 'returnProduct')->name('sale_returns.product_store');
    });
    //General Setting
    Route::controller(SettingsController::class)->group(function () {
        Route::get('settings/general-settings', 'generalSettings')->name('settings.general');
        Route::post('settings/general-settings-store/{generalSetting}', 'store')->name('settings.general.store');
        Route::post('settings/mail-settings-store', 'mailSettingsStore')->name('settings.mail.store');
        Route::get('settings/mail-settings', 'mailSettings')->name('settings.mail');
    });
    //Expense Category
    Route::controller(ExpenseCategoryController::class)->group(function () {
        Route::get('expense-categories', 'index')->name('expenseCategory.index');
        Route::post('expense-categories/store', 'store')->name('expenseCategory.store');
        Route::post('expense-categories/update/{expenseCategory}', 'update')->name('expenseCategory.update');
        Route::get('expense-categories/destroy/{expenseCategory}', 'destroy')->name('expenseCategory.destroy');
        Route::get('expense-categories/gencode', 'generateCode')->name('expenseCategory.code');
    });
    //Expense
    Route::controller(ExpenseController::class)->group(function () {
        Route::get('expense', 'index')->name('expense.index');
        Route::post('expense/store', 'store')->name('expense.store');
        Route::post('expense/update/{expense}', 'update')->name('expense.update');
        Route::get('expense/destroy/{expense}', 'destroy')->name('expense.destroy');
    });
    //Coupon
    Route::controller(CouponController::class)->group(function () {
        Route::get('coupons', 'index')->name('coupons.index');
        Route::post('coupon/store', 'store')->name('coupons.store');
        Route::post('coupon/update/{coupon}', 'update')->name('coupons.update');
        Route::get('coupon/destroy/{coupon}', 'destroy')->name('coupons.destroy');
    });

    //accounting
    Route::controller(AccountsController::class)->group(function () {
        Route::get('accounts', 'index')->name('account.index');
        Route::post('account/store', 'store')->name('account.store');
        Route::post('account/update/{account}', 'update')->name('account.update');
        Route::post('account/balance/{account}', 'updateBalance')->name('account.update.balance');
        Route::get('account/destroy/{account}', 'destroy')->name('account.destroy');
        Route::get('account/balancesheet', 'balanceSheet')->name('account.balancesheet');
    });
    //Money Transfer
    Route::controller(MoneyTransferController::class)->group(function () {
        Route::get('money-transfers', 'index')->name('moneyTransfer.index');
        Route::post('money-transfers/store', 'store')->name('moneyTransfer.store');
        Route::post('money-transfers/update/{moneyTransfer}', 'update')->name('moneyTransfer.update');
        Route::get('money-transfers/destroy/{moneyTransfer}', 'destroy')->name('moneyTransfer.destroy');
    });
    //Currency
    Route::controller(CurrencyController::class)->group(function () {
        Route::get('currency', 'index')->name('currency.index');
        Route::post('currency/store', 'store')->name('currency.store');
        Route::post('currency/update/{currency}', 'update')->name('currency.update');
        Route::get('currency/delete/{currency}', 'delete')->name('currency.delete');
    });
    // Language
    Route::controller(LanguageController::class)->group(function () {
        Route::get('language', 'index')->name('language.index');
        Route::get('language/create', 'create')->name('language.create');
        Route::post('language/store', 'store')->name('language.store');
        Route::get('language/{language}/edit', 'edit')->name('language.edit');
        Route::put('language/{language}/update', 'update')->name('language.update');
        Route::get('language/{language}/delete', 'delete')->name('language.delete');
    });
});

// Change Language
Route::get('/change-language', function () {
    if (request()->ln) {
        App::setLocale(\request()->ln);
        session()->put('local', \request()->ln);
    }
    return back();
})->name('change.local');
