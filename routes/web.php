<?php

use Laravel\Fortify\Features;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use App\Livewire\CartComponent;
use App\Livewire\ProductDetail;
use App\Livewire\CheckoutShipping;
use App\Livewire\CheckoutPayment;
use App\Livewire\CheckoutConfirmation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PayPalTestController;
use App\Livewire\OrderComponent;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/', [ShopController::class, 'index'])->name('shop.index');

Route::get('cart', CartComponent::class)->name('cart');
Route::get('product/{sku}', ProductDetail::class)->name('product.show');

Route::middleware(['auth'])->group(function () {
    Route::get('orders', OrderComponent::class)->name('orders');

    // Checkout routes
    Route::get('checkout/shipping', CheckoutShipping::class)->name('checkout.shipping');
    Route::get('checkout/payment', CheckoutPayment::class)->name('checkout.payment');
    Route::get('checkout/confirmation', CheckoutConfirmation::class)->name('checkout.confirmation');

    // PayPal callback routes
    Route::get('paypal/success', [App\Http\Controllers\PayPalController::class, 'success'])->name('paypal.success');
    Route::get('paypal/cancel', [App\Http\Controllers\PayPalController::class, 'cancel'])->name('paypal.cancel');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');
});

Route::get('/{path}', [ShopController::class, 'category'])->where('path', '.*')->name('shop.category');
