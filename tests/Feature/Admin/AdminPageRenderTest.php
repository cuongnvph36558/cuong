<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('the admin leads page renders with the shared auth props', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $response = $this->get(route('admin.leads.index'));

    $response->assertOk();
    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->component('admin/Leads')
        ->has('leads')
        ->has('filters')
        ->has('stats')
        ->has('symptoms')
        ->where('auth.user.is_admin', true)
    );
});
