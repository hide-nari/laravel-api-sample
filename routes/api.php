<?php

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/people', function () {
    return Person::all();
});

Route::get('/person/{person}', function (Person $person) {
    return $person;
});
