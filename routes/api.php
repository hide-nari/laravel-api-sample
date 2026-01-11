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

Route::post('/person/store', function (Request $request) {
    return Person::create([
        'name' => $request->name,
        'age'  => $request->age,
    ]);
});

Route::get('/person/{person}', function (Person $person) {
    return $person;
});

Route::post('/person/{person}', function (Person $person, Request $request) {
    $person->update([
        'name' => $request->name,
        'age'  => $request->age,
    ]);
});

Route::post('/person/store', function (Request $request) {
    return Person::create([
        'name' => $request->name,
        'age'  => $request->age,
    ]);
});

Route::get('/person/delete/{person}', function (Person $person) {
    $person->delete();
});
