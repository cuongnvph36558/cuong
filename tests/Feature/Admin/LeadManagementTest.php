<?php

use App\Models\Lead;
use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('admin.leads.index'));
    $response->assertRedirect(route('login'));
});

test('non admin users are forbidden', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('admin.leads.index'))->assertForbidden();
});

test('admin users can view the leads list', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    Lead::factory()->count(3)->create();

    $this->actingAs($admin);

    $response = $this->get(route('admin.leads.index'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('admin/Leads')
        ->has('leads.data', 3)
        ->where('stats.total', 3)
    );
});

test('admin users can filter leads by search term', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    Lead::factory()->create(['name' => 'Nguyen Van A', 'phone' => '0900000001']);
    Lead::factory()->create(['name' => 'Tran Thi B', 'phone' => '0900000002']);

    $this->actingAs($admin);

    $response = $this->get(route('admin.leads.index', ['search' => 'Nguyen']));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->has('leads.data', 1)
        ->where('leads.data.0.name', 'Nguyen Van A')
    );
});

test('admin users can delete a lead', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $lead = Lead::factory()->create();

    $this->actingAs($admin);

    $this->delete(route('admin.leads.destroy', $lead))->assertRedirect();

    $this->assertDatabaseMissing('leads', ['id' => $lead->id]);
});

test('admin users can export leads as csv', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    Lead::factory()->create(['name' => 'Nguyen Van A']);

    $this->actingAs($admin);

    $response = $this->get(route('admin.leads.export'));

    $response->assertOk();
    $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
});
