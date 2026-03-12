<?php

use App\Livewire\ProductAnalyzer;
use Illuminate\Support\Facades\Route;

Route::get('/', ProductAnalyzer::class)->name('home');
