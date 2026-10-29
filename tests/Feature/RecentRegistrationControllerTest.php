<?php

use App\Models\Lead;

test('the landing page social proof endpoint returns masked registrations', function () {
    Lead::factory()->create([
        'name' => 'Nguyễn Văn An',
        'address' => 'Đắk Lắk, Việt Nam',
    ]);

    $response = $this->getJson(route('registrations.recent'));

    $response->assertOk();
    $response->assertJsonStructure([
        'registrations' => [
            [
                'id',
                'name',
                'region',
                'package',
                'time',
            ],
        ],
    ]);

    $registration = $response->json('registrations.0');

    expect($registration['name'])->toBe('N. A.')
        ->and($registration['region'])->toBe('Đắk Lắk');
});

test('the social proof endpoint does not expose phone numbers', function () {
    Lead::factory()->create([
        'name' => 'Trần Thị Bình',
        'phone' => '0900000099',
    ]);

    $response = $this->getJson(route('registrations.recent'));

    $response->assertOk();
    $response->assertJsonMissing(['phone' => '0900000099']);
    expect($response->getContent())->not->toContain('0900000099');
});

test('the social proof endpoint returns an empty list when there are no leads', function () {
    $response = $this->getJson(route('registrations.recent'));

    $response->assertOk();
    $response->assertJsonCount(0, 'registrations');
});
