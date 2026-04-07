<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductdetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\admin\AdminCategoryController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\ProductController as AdminProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\KhaltiController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\WishlistController;

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/categories', [CategoryController::class, 'detail'])->name('categories');
Route::get('/categories/{slug}', [CategoryController::class, 'detail'])->name('categories.products');

Route::get('/category/{slug}', [SubcategoryController::class, 'index'])->name('subcategory.index');

Route::get('/product/{slug}', [ProductdetailController::class, 'index'])->name('product.detail');

Route::get('/category/gadgets/watch/{slug}', [ProductdetailController::class, 'index']); 

Route::get('/cart-list/{slug}', [CartController::class, 'list']);
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/checkout/{slug}', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('register', [UserController::class, 'register']);
Route::get('register1', [UserController::class, 'register1'])->name('login');

// Authentication POST routes
Route::post('/register', [UserController::class, 'registerPost'])->name('register.post');
Route::post('/login', [UserController::class, 'loginPost'])->name('login.post');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Static pages routes
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('categories', [CategoryController::class, 'index'])->name('categories');
Route::get('contact/index', [ContactController::class, 'index'])->name('contact.index');

// User dashboard routes
Route::get('user/', [UserController::class, 'index'])->name('user.dashboard');
Route::get('user/order-history/', [UserController::class, 'history'])->name('user.order.history');
Route::get('user/order-detail/{orderId}', [UserController::class, 'detail'])->name('user.order.detail');
Route::get('user/detail/', [UserController::class, 'detail']);
Route::get('user/settings/', [UserController::class, 'settings'])->name('user.settings');
Route::post('user/update-profile/', [UserController::class, 'updateProfile'])->name('user.update.profile');
Route::post('user/update-password/', [UserController::class, 'updatePassword'])->name('user.update.password');
Route::get('user/wishlist/', [UserController::class, 'wishlist'])->name('user.wishlist');
Route::resource('wishlist', WishlistController::class);
Route::match(['get', 'post'], 'user/logout', [UserController::class, 'logout'])->name('user.logout');

// Test route for debugging
Route::get('test-logout', function() {
    return 'Logout route is working: ' . route('user.logout');
});

// Admin dashboard routes
Route::get('admin/login/', [AdminController::class, 'login'])->name('admin.login');
Route::post('admin/login/', [AdminController::class, 'loginPost'])->name('admin.login.post');
Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('admin/forget/', [AdminController::class, 'forget'])->name('admin.forget');
Route::post('admin/forget/', [AdminController::class, 'forgetPost'])->name('admin.forget.post');
Route::get('admin/', [AdminController::class, 'index'])->middleware('admin');


Route::get('admin/add-product',[AdminProductController::class,'addproduct'])->name('admin.add-product')->middleware('admin');
Route::post('admin/add-product',[AdminProductController::class,'storeproduct'])->middleware('admin');
Route::get('admin/view-product',[AdminProductController::class,'viewproduct'])->name('admin.view-product')->middleware('admin');
Route::get('admin/edit-product/{p_id}',[AdminProductController::class, 'editproduct'])->name('admin.edit-product')->middleware('admin');
Route::put('admin/edit-product/{p_id}',[AdminProductController::class, 'updateproduct'])->name('admin.product.update')->middleware('admin');
Route::delete('admin/delete-product/{p_id}',[AdminProductController::class, 'deleteproduct'])->name('admin.delete-product')->middleware('admin');
Route::post('admin/products/bulk-update', [AdminProductController::class, 'bulkProductStatusUpdate'])->name('admin.products.bulk.update')->middleware('admin');

Route::get('admin/add-category', [AdminCategoryController::class, 'addcategory'])->name('admin.add-category')->middleware('admin');
Route::post('admin/add-category', [AdminCategoryController::class, 'createcategory'])->name('admin.category.store')->middleware('admin');
Route::get('admin/view-category', [AdminCategoryController::class, 'viewcategory'])->name('admin.view-category')->middleware('admin');
Route::get('admin/edit-category/{c_id}', [AdminCategoryController::class, 'editcategory'])->name('admin.edit-category')->middleware('admin');
Route::put('admin/edit-category/{c_id}', [AdminCategoryController::class, 'updatecategory'])->name('admin.update-category')->middleware('admin');
Route::delete('admin/delete-category/{c_id}', [AdminCategoryController::class, 'deletecategory'])->name('admin.delete-category')->middleware('admin');
Route::get('admin/user', [AdminUserController::class, 'index'])->name('admin.users.index')->middleware('admin');
Route::get('admin/user/create', [AdminUserController::class, 'create'])->name('admin.users.create')->middleware('admin');
Route::post('admin/user/store', [AdminUserController::class, 'store'])->name('admin.users.store')->middleware('admin');
Route::get('admin/user/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.users.edit')->middleware('admin');
Route::put('admin/user/update/{id}', [AdminUserController::class, 'update'])->name('admin.users.update')->middleware('admin');
Route::delete('admin/user/delete/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.delete')->middleware('admin');
Route::get('admin/user/view/{id}', [AdminUserController::class, 'show'])->name('admin.users.show')->middleware('admin');
Route::post('admin/user/block/{id}', [AdminUserController::class, 'block'])->name('admin.users.block')->middleware('admin');
Route::post('admin/user/unblock/{id}', [AdminUserController::class, 'unblock'])->name('admin.users.unblock')->middleware('admin');
Route::post('admin/user/bulk-action', [AdminUserController::class, 'bulkAction'])->name('admin.users.bulk')->middleware('admin');

// Order Management Routes
Route::get('admin/orders', [AdminController::class, 'ordersIndex'])->name('admin.orders.index')->middleware('admin');
Route::get('admin/orders/{id}', [AdminController::class, 'orderShow'])->name('admin.orders.show')->middleware('admin');
Route::post('admin/orders/{id}', [AdminController::class, 'orderUpdate'])->name('admin.orders.update')->middleware('admin');
Route::delete('admin/orders/{id}', [AdminController::class, 'orderDestroy'])->name('admin.orders.destroy')->middleware('admin');
Route::post('admin/orders/bulk-update', [AdminController::class, 'bulkOrderStatusUpdate'])->name('admin.orders.bulk.update')->middleware('admin');

Route::get('admin/details', [AdminController::class, 'details'])->name('admin.details')->middleware('admin');

Route::get('/inventory', [AdminController::class, 'inventory'])->name('inventory.index');
Route::get('/inventory/create', [AdminController::class, 'inventoryCreate'])->name('inventory.create');
Route::post('/inventory/store', [AdminController::class, 'inventoryStore'])->name('inventory.store');
Route::get('/inventory/edit/{id}', [AdminController::class, 'inventoryEdit'])->name('inventory.edit');
Route::put('/inventory/update/{id}', [AdminController::class, 'inventoryUpdate'])->name('inventory.update');
Route::delete('/inventory/delete/{id}', [AdminController::class, 'inventoryDestroy'])->name('inventory.delete');
Route::get('/inventory/view/{id}', [AdminController::class, 'inventoryShow'])->name('inventory.show');

Route::get('/sales-report', [AdminController::class, 'salesReport'])->name('sales.report');
Route::post('/sales-report/filter', [AdminController::class, 'salesReportFilter'])->name('sales.report.filter');
Route::get('/purchase-report', [AdminController::class, 'purchaseReport'])
    ->name('purchase.report');

Route::post('/purchase-report/filter', [AdminController::class, 'purchaseReportFilter'])
    ->name('purchase.report.filter');

// Review routes
Route::post('/review/submit', [ReviewController::class, 'submit'])->name('review.submit');

// Search routes
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');
Route::get('/search', [SearchController::class, 'search'])->name('search');



Route::get('/khalti-test', function () {
    return view('khalti');
});
Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
