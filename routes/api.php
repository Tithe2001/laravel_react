<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/customers',[CustomerController::class, 'index']);

Route::get('/order',[OrderController::class, 'index']);
Route::get("order/orderInvoice/{id}", [OrderController::class,"invoice"]);
Route::get("customer", [OrderController::class,"orderData"]);
Route::post("order/react_order_save", [OrderController::class,"react_order_save"]);

Route::get('/order/find/{id}', [OrderController::class, 'find']);
Route::put('/order/update', [OrderController::class, 'updateByReact']);
Route::delete('/order/delete', [OrderController::class, 'delete']);




Route::get('/purchase',[PurchaseController::class, 'index']);
Route::get('/purchase/find/{id}', [PurchaseController::class, 'find']);
Route::get('/purchase/invoice/{id}', [PurchaseController::class, 'invoice']);
Route::get('/purchase/data', [PurchaseController::class, 'purchaseData']);
Route::post('/purchase/react_purchase_save', [PurchaseController::class, 'react_purchase_save']);
Route::delete('/purchase/delete', [PurchaseController::class, 'delete']);


Route::get('/stock',[StockController::class, 'index']);


Route::get("role/find/{id}", [RoleController::class,"show"]);
Route::put("role/update", [RoleController::class,"update"]);
Route::delete("role/delete", [RoleController::class,"destroy"]);



