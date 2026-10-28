<?php

use App\Models\Lead;

test('guests can submit the landing page form', function () {
    $response = $this->post(route('leads.store'), [
        'name' => 'Nguyen Van A',
        'phone' => '0900000001',
        'address' => 'Hà Nội',
        'coupon_code' => 'HT212',
        'plant_type' => 'Cây ăn quả',
        'symptoms' => ['VÀNG LÁ', 'THỐI RỂ'],
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('leads', [
        'name' => 'Nguyen Van A',
        'phone' => '0900000001',
        'coupon_code' => 'HT212',
    ]);

    $lead = Lead::first();

    expect($lead->symptoms)->toBe(['VÀNG LÁ', 'THỐI RỂ']);
});

test('the name is required', function () {
    $this->post(route('leads.store'), [
        'phone' => '0900000001',
    ])->assertSessionHasErrors('name');

    $this->assertDatabaseCount('leads', 0);
});

test('the phone is required', function () {
    $this->post(route('leads.store'), [
        'name' => 'Nguyen Van A',
    ])->assertSessionHasErrors('phone');

    $this->assertDatabaseCount('leads', 0);
});

test('an invalid symptom is rejected', function () {
    $this->post(route('leads.store'), [
        'name' => 'Nguyen Van A',
        'phone' => '0900000001',
        'symptoms' => ['KHÔNG TỒN TẠI'],
    ])->assertSessionHasErrors('symptoms.0');

    $this->assertDatabaseCount('leads', 0);
});

test('the landing page renders', function () {
    $this->get(route('home'))->assertOk();
});
