<?php

namespace App\Traits;

use Route;

trait RouteTrait {
    public static function productVariantOptionRoute(): void
    {
        Route::as('products-variant-option.')->group(function () {
            Route::put('products-variant-option/change-status', 'changeStatus')
                ->name('change-status');
            Route::put('products-variant-option/change-is-default', 'changeIsDefault')
                ->name('change-is-default');
            Route::get('products-variant-option/{productId}/{variantId}', 'index')->name('index');
            Route::get('products-variant-option/create/{productId}/{variantId}', 'create')
                ->name('create');
            Route::post('products-variant-option', 'store')->name('store');
            Route::get('products-variant-option-edit/{variantOptionId}', 'edit')->name('edit');
            Route::put('products-variant-option-update/{variantOptionId}', 'update')->name('update');
            Route::delete('products-variant-option/{variantOptionId}', 'destroy')->name('destroy');
        });
    }
}
