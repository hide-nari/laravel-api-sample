<?php

use App\Models\Person;
use Illuminate\Support\Carbon;

test('person model api index view two records', function () {
    Person::factory()->create();
    Person::factory()->create([
        'name' => 'jiro',
        'age'  => 20,
    ]);

    $response = $this->get('/api/people');

    $response->assertStatus(200);

    expect($response->json()[0]['name'])->not()->toBeNull()
        ->and($response->json()[0]['age'])->not()->toBeNull()
        ->and($response->json()[1]['name'])->toBe('jiro')
        ->and($response->json()[1]['age'])->toBe(20);
});

test('person model api person one', function () {
    $workTime = Carbon::now();
    Person::create([
        'name' => 'taro',
        'age'  => 15,
    ]);
    $response = $this->get('/api/person/1');

    $response->assertStatus(200);

    expect($response->json('name'))->toBe('taro')
        ->and($response->json('age'))->toBe(15)
        ->and(Carbon::parse($response->json('created_at'))
            ->toAtomString())->toBe($workTime->toAtomString())
        ->and(Carbon::parse($response->json('updated_at'))
            ->toAtomString())->toBe($workTime->toAtomString());
});

test('person model api person not found pattern', function () {
    $response = $this->get('/api/person/1');
    $response->assertStatus(404);
});

test('person model api store pattern', function () {
    $workTime = Carbon::now();

    $response = $this->post('/api/person/store',
        ['name' => 'taro', 'age' => 15]);

    $response->assertStatus(201);

    $person = Person::find(1);

    expect($person->name)->toBe('taro')
        ->and($person->age)->toBe(15)
        ->and($person->created_at->toAtomString())
        ->toBe($workTime->toAtomString())
        ->and($person->updated_at->toAtomString())
        ->toBe($workTime->toAtomString());
});

test('person model api person no name error', function () {
    $response = $this->post('/api/person/store',
        ['age' => 15]);

    $response->assertStatus(302);
});

test('person model api person no age error', function () {
    $response = $this->post('/api/person/store',
        ['name' => 'taro']);

    $response->assertStatus(302);
});

test('person model api update pattern', function () {
    $response = $this->post('/api/person/store',
        ['name' => 'taro', 'age' => 15]);

    $response->assertStatus(201);

    sleep(1);

    $workTime = Carbon::now();

    $responseTwo = $this->post('/api/person/1',
        ['name' => 'jiro', 'age' => 20]);

    $responseTwo->assertStatus(200);

    $person = Person::find(1);

    expect($person->name)->toBe('jiro')
        ->and($person->age)->toBe(20)
        ->and($person->created_at->toAtomString())
        ->not()->toBe($workTime->toAtomString())
        ->and($person->updated_at->toAtomString())
        ->toBe($workTime->toAtomString());

});

test('person model api update no name pattern', function () {
    $response = $this->post('/api/person/store',
        ['name' => 'taro', 'age' => 15]);

    $response->assertStatus(201);

    sleep(1);

    $responseTwo = $this->post('/api/person/1',
        ['age' => 20]);

    $responseTwo->assertStatus(302);
});

test('person model api update no age pattern', function () {
    $response = $this->post('/api/person/store',
        ['name' => 'taro', 'age' => 15]);

    $response->assertStatus(201);

    $responseTwo = $this->post('/api/person/1',
        ['name' => 'taro']);

    $responseTwo->assertStatus(302);
});

test('person model api delete pattern', function () {
    $workTime = Carbon::now();

    $this->post('/api/person/store',
        ['name' => 'taro', 'age' => 15]);

    $response = $this->get('/api/person/delete/1');

    $response->assertStatus(200);

    $person = Person::find(1);

    expect($person)->toBeNull();

    $person = Person::withTrashed()->find(1);

    expect($person->name)->toBe('taro')
        ->and($person->deleted_at->toAtomString())
        ->toBe($workTime->toAtomString());
});

