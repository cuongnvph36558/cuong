<?php

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('guests are redirected to the login page', function () {
    $this->get(route('admin.feedbacks.index'))->assertRedirect(route('login'));
});

test('non admin users are forbidden', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.feedbacks.index'))->assertForbidden();
});

test('admin users can view the feedback list', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    Feedback::factory()->count(3)->create();

    $this->actingAs($admin);

    $response = $this->get(route('admin.feedbacks.index'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('admin/Feedbacks')
        ->has('feedbacks.data', 3)
        ->where('stats.total', 3)
    );
});

test('admin users can open the feedback creation form', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $this->get(route('admin.feedbacks.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('admin/FeedbackForm')
            ->where('feedback', null)
        );
});

test('admin users can store a feedback with photos', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $response = $this->post(route('admin.feedbacks.store'), [
        'name' => 'Nguyen Van A',
        'role' => 'Chủ trại cà phê',
        'rating' => 5,
        'content' => 'Cây ra đọt rất nhanh.',
        'image' => '/storage/feedbacks/avatar.jpg',
        'photos' => [
            '/storage/feedbacks/plant-1.jpg',
            '/storage/feedbacks/plant-2.jpg',
        ],
        'is_featured' => true,
        'sort_order' => 3,
    ]);

    $response->assertRedirect(route('admin.feedbacks.index'));

    $this->assertDatabaseHas('feedbacks', [
        'name' => 'Nguyen Van A',
        'rating' => 5,
        'is_featured' => true,
        'sort_order' => 3,
    ]);

    $feedback = Feedback::first();

    expect($feedback->photos)->toBe([
        '/storage/feedbacks/plant-1.jpg',
        '/storage/feedbacks/plant-2.jpg',
    ])->and($feedback->image)->toBe('/storage/feedbacks/avatar.jpg');
});

test('the rating must be between one and five', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $this->post(route('admin.feedbacks.store'), [
        'name' => 'Nguyen Van A',
        'rating' => 6,
        'content' => 'Nội dung',
    ])->assertSessionHasErrors('rating');

    $this->assertDatabaseCount('feedbacks', 0);
});

test('admin users can update a feedback', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $feedback = Feedback::factory()->create(['name' => 'Tên cũ']);

    $this->actingAs($admin);

    $this->put(route('admin.feedbacks.update', $feedback), [
        'name' => 'Tên mới',
        'rating' => 4,
        'content' => 'Nội dung mới',
        'photos' => [],
    ])->assertRedirect(route('admin.feedbacks.index'));

    expect($feedback->fresh()->name)->toBe('Tên mới')
        ->and($feedback->fresh()->rating)->toBe(4);
});

test('admin users can delete a feedback', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $feedback = Feedback::factory()->create();

    $this->actingAs($admin);

    $this->delete(route('admin.feedbacks.destroy', $feedback))
        ->assertRedirect();

    $this->assertDatabaseMissing('feedbacks', ['id' => $feedback->id]);
});

test('admin users can upload a feedback image', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $response = $this->post(route('admin.feedbacks.upload'), [
        'image' => UploadedFile::fake()->image('feedback.jpg'),
    ]);

    $response->assertOk();

    $path = $response->json('path');

    expect($path)->toStartWith('/storage/feedbacks/');

    Storage::disk('public')->assertExists('feedbacks/'.basename($path));
});

test('the upload request rejects a non image file', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $this->post(route('admin.feedbacks.upload'), [
        'image' => UploadedFile::fake()->create('document.pdf', 100),
    ])->assertSessionHasErrors('image');
});

test('the landing page only shows featured feedback', function () {
    Feedback::factory()->create([
        'name' => 'Khách nổi bật',
        'is_featured' => true,
    ]);
    Feedback::factory()->create([
        'name' => 'Khách ẩn',
        'is_featured' => false,
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('Home')
        ->has('feedbacks', 1)
        ->where('feedbacks.0.name', 'Khách nổi bật')
    );
});

test('the landing page exposes the feedback photos', function () {
    Feedback::factory()->create([
        'name' => 'Khách có ảnh',
        'is_featured' => true,
        'photos' => ['/storage/feedbacks/plant-1.jpg'],
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->where('feedbacks.0.photos', ['/storage/feedbacks/plant-1.jpg'])
    );
});
