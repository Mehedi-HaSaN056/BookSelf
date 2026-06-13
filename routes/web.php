<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController, BookController, CategoryController,
    VendorController, ReportController, AuthController, PaymentController
};

// Auth Routes (no middleware)
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Books
    Route::get('/books/export/excel', [BookController::class, 'exportExcel'])->name('books.export.excel');
    Route::get('/books/export/pdf',   [BookController::class, 'exportPdf'])->name('books.export.pdf');
    Route::get('/books/sample/excel', [BookController::class, 'sampleExcel'])->name('books.sample.excel');
    Route::post('/books/import',      [BookController::class, 'importExcel'])->name('books.import');
    Route::patch('/books/{book}/status', [BookController::class, 'updateStatus'])->name('books.status');
    Route::resource('books', BookController::class);

    // Categories & Vendors
    Route::resource('categories', CategoryController::class)->except(['show','create','edit']);
    Route::resource('vendors', VendorController::class)->except(['show','create','edit']);
    Route::post('/vendors/import',        [VendorController::class, 'importExcel'])->name('vendors.import');
    Route::get('/vendors/export/excel',   [VendorController::class, 'exportExcel'])->name('vendors.export.excel');

    // Reports & Budget
    Route::get('/reports/budget',     [ReportController::class, 'budget'])->name('reports.budget');
    Route::post('/reports/budget',    [ReportController::class, 'setBudget'])->name('reports.budget.set');
    Route::get('/reports/budget/pdf', [ReportController::class, 'exportBudgetPdf'])->name('reports.budget.pdf');
// SSLCommerz Callbacks — auth ছাড়া
Route::post('/sslcommerz/success', [PaymentController::class, 'sslSuccess'])->name('sslcommerz.success');
Route::post('/sslcommerz/fail',    [PaymentController::class, 'sslFail'])->name('sslcommerz.fail');
Route::post('/sslcommerz/cancel',  [PaymentController::class, 'sslCancel'])->name('sslcommerz.cancel');
Route::post('/sslcommerz/ipn',     [PaymentController::class, 'sslIpn'])->name('sslcommerz.ipn');

// Payments — auth দরকার
Route::middleware('auth')->group(function () {
    Route::get('/payments',          [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create',   [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments',         [PaymentController::class, 'store'])->name('payments.store');
    Route::post('/payments/ssl-pay', [PaymentController::class, 'sslPay'])->name('payments.sslPay');
});