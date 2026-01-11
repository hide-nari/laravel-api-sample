<?php

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/people', function () {
    return Person::all();
});

Route::get('/person/{person}', fn(Person $person) => $person);

Route::post('/person/store', function (Request $request) {
    return Person::create($request->validate([
        'name' => ['required'],
        'age'  => ['required', 'integer'],
    ]));
});

Route::post('/person/{person}', function (Person $person, Request $request) {
    return $person->update($request->validate([
        'name' => ['required'],
        'age'  => ['required', 'integer'],
    ]));
});

Route::get('/person/delete/{person}', function (Person $person) {
    return $person->delete();
});
