<?php

use App\Models\SiteSetting;
use App\Models\User;
use App\Support\HomeContent;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia;

test('guests are redirected to the login page', function () {
    $this->get(route('admin.home-content.edit'))->assertRedirect(route('login'));
});

test('non admin users are forbidden', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.home-content.edit'))->assertForbidden();
});

test('admin users can view the home content editor', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $response = $this->get(route('admin.home-content.edit'));

    $response->assertOk();
    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->component('admin/HomeContent')
        ->has('schema')
        ->has('content')
        ->where('content.hero.brandName', 'ROOTBIO')
    );
});

test('admin users can update the home content', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $content = HomeContent::get();
    $content['hero']['brandName'] = 'THƯƠNG HIỆU MỚI';
    $content['hero']['titleAccent'] = 'BIO';
    $content['plantTypes']['heading'] = 'Tiêu đề mới';

    $response = $this->put(route('admin.home-content.update'), [
        'content' => $content,
    ]);

    $response->assertOk();

    $this->assertDatabaseHas('site_settings', [
        'key' => HomeContent::STORAGE_KEY,
    ]);

    $stored = HomeContent::get();

    expect($stored['hero']['brandName'])->toBe('THƯƠNG HIỆU MỚI')
        ->and($stored['hero']['titleAccent'])->toBe('BIO')
        ->and($stored['plantTypes']['heading'])->toBe('Tiêu đề mới');
});

test('the landing page renders the stored content', function () {
    SiteSetting::put(HomeContent::STORAGE_KEY, [
        ...HomeContent::defaults(),
        'hero' => [
            ...HomeContent::defaults()['hero'],
            'brandName' => 'THƯƠNG HIỆU MỚI',
        ],
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->component('Home')
        ->where('content.hero.brandName', 'THƯƠNG HIỆU MỚI')
    );
});

test('admin users can reset the home content to the defaults', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    SiteSetting::put(HomeContent::STORAGE_KEY, [
        ...HomeContent::defaults(),
        'hero' => [
            ...HomeContent::defaults()['hero'],
            'brandName' => 'THƯƠNG HIỆU MỚI',
        ],
    ]);

    $this->actingAs($admin);

    $response = $this->post(route('admin.home-content.reset'));

    $response->assertOk();

    expect(HomeContent::get()['hero']['brandName'])->toBe('ROOTBIO');
});

test('non admin users cannot update the home content', function () {
    $this->actingAs(User::factory()->create());

    $this->put(route('admin.home-content.update'), [
        'content' => HomeContent::defaults(),
    ])->assertForbidden();

    expect(HomeContent::get()['hero']['brandName'])->toBe('ROOTBIO');
});

test('the update request rejects invalid content', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $this->put(route('admin.home-content.update'), [
        'content' => ['solutions' => ['statsValue' => 'không phải số']],
    ])->assertSessionHasErrors('content.solutions.statsValue');
});

test('the update request accepts repeatable list fields', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $content = HomeContent::defaults();
    $content['hero']['features'] = [
        ['value' => 'Điểm nổi bật mới'],
        ['value' => 'Điểm nổi bật thứ hai'],
    ];
    $content['problems']['items'] = [
        [
            'title' => 'Vấn đề mới',
            'description' => 'Mô tả vấn đề mới',
            'image' => '/images/rootbio/problem1.jpg',
        ],
    ];

    $response = $this->put(route('admin.home-content.update'), [
        'content' => $content,
    ]);

    $response->assertOk();
    $response->assertSessionHasNoErrors();

    $stored = HomeContent::get();

    expect($stored['hero']['features'])->toHaveCount(2)
        ->and($stored['hero']['features'][0]['value'])->toBe('Điểm nổi bật mới')
        ->and($stored['problems']['items'])->toHaveCount(1)
        ->and($stored['problems']['items'][0]['title'])->toBe('Vấn đề mới');
});

test('admin users can upload an image for the home content', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $response = $this->post(route('admin.home-content.upload'), [
        'image' => UploadedFile::fake()->image('banner.jpg'),
    ]);

    $response->assertOk();

    $path = $response->json('path');

    expect($path)->toStartWith('/storage/home-content/');

    Storage::disk('public')->assertExists(
        'home-content/'.basename($path),
    );
});

test('the upload request rejects a non image file', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $this->post(route('admin.home-content.upload'), [
        'image' => UploadedFile::fake()->create('document.pdf', 100),
    ])->assertSessionHasErrors('image');
});
