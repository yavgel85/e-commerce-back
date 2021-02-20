<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = \App\Models\Category::parents()->ordered()->get()->dd();
});
