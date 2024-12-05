<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CarBodyTypeController;
use App\Http\Controllers\API\CarCategoryController;
use App\Http\Controllers\API\CarController;
use App\Http\Controllers\API\CarMakeController;
use App\Http\Controllers\API\CarModelController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CarVariantController;
use App\Http\Controllers\API\DealController;
use App\Http\Controllers\API\DocumentationController;
use App\Http\Controllers\API\DocumentServiceController;
use App\Http\Controllers\API\InquiryController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\OfferVehicleController;
use App\Http\Controllers\API\OrderVehicleController;
use App\Http\Controllers\API\PaymentMethodController;
use App\Http\Controllers\API\ProductCategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductSubCategoryController;
use App\Http\Controllers\API\QuotationController;
use App\Http\Controllers\API\StatusTrackingController;
use App\Http\Controllers\API\SupplyContractController;
use App\Http\Controllers\API\TenderController;
use App\Http\Controllers\API\UserPanelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/send-code', [AuthController::class, 'sendCode']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum', \App\Http\Middleware\CorsMiddleware::class, \App\Http\Middleware\TokenExpiration::class])->group(function () {
    Route::get('/verify-token', [AuthController::class, 'verifyToken']);

    Route::controller(ProductController::class)->prefix('product')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{product}', 'show');
        Route::get('/edit/{product}', 'edit');
        Route::post('/update/{product}', 'update');
        Route::delete('/delete/{product}', 'destroy');
        Route::get('/by-category/{name}', 'getProductByCategory');
        Route::get('/update-wishlist/{product}', 'updateWishlist');
        Route::get('/wishlist', 'getWishlist');
    });

    Route::controller(ProductCategoryController::class)->prefix('product-category')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{productCategory}', 'show');
        Route::get('/edit/{productCategory}', 'edit');
        Route::post('/update/{productCategory}', 'update');
        Route::delete('/delete/{productCategory}', 'destroy');
    });

    Route::controller(ProductSubCategoryController::class)->prefix('product-sub-category')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{productSubCategory}', 'show');
        Route::get('/edit/{productSubCategory}', 'edit');
        Route::post('/update/{productSubCategory}', 'update');
        Route::delete('/delete/{productSubCategory}', 'destroy');
        Route::get('/by-category/{productCategory}', 'getSubCategoryByCategory');
    });

    Route::controller(CarController::class)->prefix('car')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{car}', 'show');
        Route::get('/edit/{car}', 'edit');
        Route::post('/update/{car}', 'update');
        Route::delete('/delete/{car}', 'destroy');
        Route::get('/listing', 'getCarsByBrandSlug');
        Route::get('/detail/{slug}', 'getCarsDetailsBySlug');
        Route::get('/book/{car}', 'bookCar');
    });

    Route::controller(CarMakeController::class)->prefix('car-make')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{carMake}', 'show');
        Route::get('/edit/{carMake}', 'edit');
        Route::post('/update/{carMake}', 'update');
        Route::delete('/delete/{carMake}', 'destroy');
        Route::get('/featured/{withCarList}', 'getFeaturedCarMakes');
    });

    Route::controller(CarModelController::class)->prefix('car-model')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{carModel}', 'show');
        Route::get('/edit/{carModel}', 'edit');
        Route::post('/update/{carModel}', 'update');
        Route::delete('/delete/{carModel}', 'destroy');
        Route::get('/by-car-make/{carMake}', 'getCarModelByMake');
        Route::get('/by-car-make-slug/{slug}', 'getCarModelByMakeSlug');
    });

    Route::controller(CarVariantController::class)->prefix('car-variant')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{carVariant}', 'show');
        Route::get('/edit/{carVariant}', 'edit');
        Route::post('/update/{carVariant}', 'update');
        Route::delete('/delete/{carVariant}', 'destroy');
        Route::get('/by-car-model/{carModel}', 'getVariantByModel');
        Route::get('/by-car-model-slug/{$slug}', 'getVariantByModelSlug');
    });

    Route::controller(CarCategoryController::class)->prefix('car-category')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{carCategory}', 'show');
        Route::get('/edit/{carCategory}', 'edit');
        Route::post('/update/{carCategory}', 'update');
        Route::delete('/delete/{carCategory}', 'destroy');
    });

    Route::controller(CarBodyTypeController::class)->prefix('car-body-type')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{carBodyType}', 'show');
        Route::get('/edit/{carBodyType}', 'edit');
        Route::post('/update/{carBodyType}', 'update');
        Route::delete('/delete/{carBodyType}', 'destroy');
    });

    Route::controller(TenderController::class)->prefix('tender')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{tender}', 'show');
        Route::get('/edit/{tender}', 'edit');
        Route::post('/update/{tender}', 'update');
        Route::delete('/delete/{tender}', 'destroy');
    });

    Route::controller(SupplyContractController::class)->prefix('supply-contract')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{supplyContract}', 'show');
        Route::get('/edit/{supplyContract}', 'edit');
        Route::post('/update/{supplyContract}', 'update');
        Route::delete('/delete/{supplyContract}', 'destroy');
    });

    Route::controller(QuotationController::class)->prefix('quotation')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{quotation}', 'show');
        Route::get('/edit/{quotation}', 'edit');
        Route::post('/update/{quotation}', 'update');
        Route::delete('/delete/{quotation}', 'destroy');
    });

    Route::controller(DealController::class)->prefix('deal')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{deal}', 'show');
        Route::get('/edit/{deal}', 'edit');
        Route::post('/update/{deal}', 'update');
        Route::delete('/delete/{deal}', 'destroy');
    });

    Route::controller(CartController::class)->prefix('cart')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{deal}', 'show');
        Route::get('/edit/{deal}', 'edit');
        Route::post('/update/{deal}', 'update');
        Route::delete('/delete/{deal}', 'destroy');
        Route::get('/get-items-by-user/{user}', 'getItemsByUser');
        Route::post('/update-item', 'updateCart');
    });

    Route::controller(PaymentMethodController::class)->prefix('payment-method')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{paymentMethod}', 'show');
        Route::get('/edit/{paymentMethod}', 'edit');
        Route::post('/update/{paymentMethod}', 'update');
        Route::delete('/delete/{paymentMethod}', 'destroy');
        Route::get('/get-payment-methods', 'getPaymentMethods');
    });

    Route::controller(InquiryController::class)->prefix('inquiry')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{inquiry}', 'show');
        Route::get('/edit/{inquiry}', 'edit');
        Route::post('/update/{inquiry}', 'update');
        Route::delete('/delete/{inquiry}', 'destroy');
    });

    Route::controller(OrderVehicleController::class)->prefix('order-vehicle')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{vehicleOrder}', 'show');
        Route::get('/edit/{vehicleOrder}', 'edit');
        Route::post('/update/{vehicleOrder}', 'update');
        Route::delete('/delete/{vehicleOrder}', 'destroy');
    });

    Route::controller(OfferVehicleController::class)->prefix('offer-vehicle')->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{offerVehicle}', 'show');
        Route::get('/edit/{offerVehicle}', 'edit');
        Route::post('/update/{offerVehicle}', 'update');
        Route::delete('/delete/{offerVehicle}', 'destroy');
    });

    Route::controller(LocationController::class)->prefix('location')->group(function () {
        Route::get('/countries', 'getCountries');
        Route::get('/states/{country}', 'getCountryStates');
        Route::get('/cities/{country}/{state}', 'getStateCities');
        Route::get('/ports/{country}/{state}/{city}', 'getCityPorts');
    });

    Route::controller(StatusTrackingController::class)->prefix('status-tracking')->group(function () {
        Route::post('/update', 'updateStatus');
        Route::post('/get', 'getStatus');
    });

    Route::prefix('documentation')->group(function () {
        Route::controller(DocumentationController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/store', 'store');
            Route::get('/show/{documentation}', 'show');
            Route::get('/edit/{documentation}', 'edit');
            Route::post('/update/{documentation}', 'update');
            Route::delete('/delete/{documentation}', 'destroy');
        });

        Route::controller(DocumentServiceController::class)->prefix('service')->group(function () {
            Route::get('/', 'index');
            Route::post('/store', 'store');
            Route::get('/show/{documentService}', 'show');
            Route::get('/edit/{documentService}', 'edit');
            Route::post('/update/{documentService}', 'update');
            Route::delete('/delete/{documentService}', 'destroy');
            Route::get('/active-services', 'getActiveServices');
        });
    });


    Route::controller(UserPanelController::class)->prefix('user-panel')->group(function () {
        Route::post('/get-forms', 'getForms');
        Route::get('/inquiries', 'userInquiries');
        Route::get('/car-bookings', 'userCarBooking');
    });

});
