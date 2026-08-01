<?php

use Illuminate\Support\Facades\Route;
use App\Model\Category;

Route::get('/', function () {
    return view('welcome');
});