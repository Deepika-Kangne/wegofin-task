<?php

use App\Http\Controllers\EmiController;
use App\Models\ClientLoanDetails;   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/loan-details', function (Request $request) {
    return ClientLoanDetails::all();
});

Route::get('/emi-details', [EmiController::class, 'get_emi_details']);