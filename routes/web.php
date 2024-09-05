<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Getdat;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('clients.index');
})->name('homepage');
*/

Route::get('/', [Getdat::class , 'homepage'])->name('homepage');




Route::get('/Educational-Tools',[Getdat::class , 'educationaltools'] )->name('edutol');

Route::get('/books-and-Novels',[Getdat::class , 'booknovels'] )->name('bandn');

Route::get('/les-packs',[Getdat::class , 'lespacks'] )->name('lespacks');


Route::get('/contact-us', function () {
    return view('clients.contactus');
})->name('contactus');


Route::get('/voirproduct/{id}', [Getdat::class , 'voirproduct'] )->name('voirproduct');










Route::get('/pannier', [Getdat::class, 'sendpannier'])->name('sendpannier');
Route::delete('/pannier/remove/{id}', [Getdat::class, 'removeFromCart'])->name('cart.remove');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('remove-from-cart');
Route::post('/clear-cart', [CartController::class, 'clearCart'])->name('clear-cart');

Route::get('/checkout/infoForm', [OrderController::class, 'checkoutform'])->name('order.checkoutform');

Route::post('/order/review', [OrderController::class, 'handleInformationForm'])->name('order.presubmit');

Route::get('/order/look', [OrderController::class, 'showReviewPage'])->name('order.review');

Route::post('/order/cancel', [OrderController::class, 'cancelorder'])->name('order.cancel');

Route::post('/order/submit', [OrderController::class, 'submitOrder'])->name('order.submit');


Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');




// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* product routes */
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/storeproduct', [ProductController::class, 'store'])->name('insertproduct');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/products/images/{id}/delete', [ProductController::class, 'deleteImage'])->name('products.images.delete');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');


    Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');


    /* End Categorie Routes */



    /* Categorie Routes */
    Route::prefix('categories')->group(function () {

        Route::get('/', [CategoryController::class, 'index'])->name('categories');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store'); // Save new category
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update'); //   Update an existing category
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy'); // Delete a category

    });
    /*  End Categorie Routes */



    /* Promotions Routes */
    Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');
    Route::get('/promotions/{id}/edit', [PromotionController::class, 'edit'])->name('promotions.edit');
    Route::get('/admin/promotionnns', [PromotionController::class, 'index'])->name('admin.promotions');
    Route::delete('/promotions/{id}/destroy', [PromotionController::class, 'destroy'])->name('promotions.destroy');
    Route::put('/promotions/{id}', [PromotionController::class, 'update'])->name('promotions.update');


    Route::get('/admin/orders', [OrderController::class, 'adminindex'])->name('orders.index');

    Route::get('/admin/order/{id}', [AdminOrderController::class, 'showOrder'])->name('orders.show');
    Route::post('/admin/order/update/{id}', [AdminOrderController::class, 'updateOrder'])->name('orders.update');
    Route::get('/inbox', [AdminOrderController::class , 'inbox'])->name('inbox');
    


    Route::prefix('packs')->group(function () {
        Route::get('/', [PackController::class, 'index'])->name('packs');
        Route::get('/create', [PackController::class, 'create'])->name('packs.create');
        Route::post('/create/submit', [PackController::class, 'store'])->name('packs.store');
        Route::get('/{id}', [PackController::class, 'show'])->name('packs.view');
        Route::get('/{id}/edit', [PackController::class, 'edit'])->name('packs.edit');
        Route::put('/{id}/update', [PackController::class, 'update'])->name('packs.update');
        Route::delete('/{id}/destroy', [PackController::class, 'destroy'])->name('packs.destroy');
    });
});





Route::get('/dashboard', [Getdat::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pack/{id}', [Getdat::class, 'showpack'])->name('showpack');










require __DIR__ . '/auth.php';
