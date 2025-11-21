<?php

use Laravel\Fortify\Features;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use App\Livewire\CartComponent;
use App\Livewire\ProductDetail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Livewire\OrderComponent;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/', [ShopController::class, 'index'])->name('shop.index');

Route::get('cart', CartComponent::class)->name('cart');
Route::get('product/{sku}', ProductDetail::class)->name('product.show');

Route::middleware(['auth'])->group(function () {
    Route::get('orders', OrderComponent::class)->name('orders');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');
});

Route::get('/{path}', [ShopController::class, 'category'])->where('path', '.*')->name('shop.category');
