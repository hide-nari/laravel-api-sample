<?php

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/people', function () {
    return Person::all();
});

Route::post('/person/store', function (Request $request) {
    $data = $request->validate([
        'name' => ['required'],
        'age'  => ['required', 'integer'],
    ]);

    return Person::create($data);
});

Route::get('/person/{person}', function (Person $person) {
    return $person;
});

Route::post('/person/{person}', function (Person $person, Request $request) {
    $data = $request->validate([
        'name' => ['required'],
        'age'  => ['required', 'integer'],
    ]);

    $person->update($data);

    return $person;
});

Route::get('/person/delete/{person}', function (Person $person) {
    $person->delete();

    return $person->withTrashed()->get();
});
