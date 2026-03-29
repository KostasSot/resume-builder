<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ResumeBuilder;

Route::get('/', ResumeBuilder::class);

//cv access
Route::get('/{resume?}', ResumeBuilder::class);
