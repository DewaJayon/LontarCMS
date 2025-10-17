<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

test('users page can rendered by admin', function () {

    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin)
        ->get(route('users.index'))
        ->assertInertia(
            fn(Assert $page) => $page
                ->component('User/Index')
                ->has('users')
        );
});

test('users page can not be rendered by staff', function () {
    $staff = User::factory()->create(['role' => 'staff']);

    actingAs($staff)
        ->get(route('users.index'))
        ->assertForbidden();
});

test('admin can search user by name or email or role', function () {

    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin)
        ->get(route('users.index', ['search' => 'admin']))
        ->assertInertia(
            fn(Assert $page) => $page
                ->component('User/Index')
                ->has('users')
        );
});

test('render users page with pagination', function () {

    $admin = User::factory()->create(['role' => 'admin']);

    User::factory(20)->create();

    actingAs($admin)
        ->get(route('users.index'))
        ->assertInertia(
            fn(Assert $page) => $page
                ->component('User/Index')
                ->has('users.data', 10)
                ->has('users.links')
        );
});

test('expect per_page is 5', function () {

    $admin = User::factory()->create(['role' => 'admin']);

    User::factory(20)->create();

    actingAs($admin)
        ->get(route('users.index', ['per_page' => 5]))
        ->assertInertia(
            fn(Assert $page) => $page
                ->component('User/Index')
                ->where('users.per_page', 5)
        );
});

test('create page must be not found', function () {

    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin)
        ->get(route('users.create'))
        ->assertNotFound();
});

test('admin can create user', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin)
        ->post(route('users.store'), [
            'name'                  => 'Test User',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'role'                  => 'admin',
        ])
        ->assertRedirectToRoute('users.index')
        ->assertSessionHas('success', 'User berhasil dibuat.');

    assertDatabaseHas('users', [
        'name'      => 'Test User',
        'email'     => 'test@example.com',
        'role'      => 'admin',
    ]);
});

test('staff can not create user', function () {
    $staff = User::factory()->create(['role' => 'staff']);

    actingAs($staff)
        ->post(route('users.store'), [
            'name'                  => 'Test User',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'role'                  => 'admin',
        ])
        ->assertForbidden();

    assertDatabaseMissing('users', [
        'name'      => 'Test User',
        'email'     => 'test@example.com',
        'role'      => 'admin',
    ]);
});

test('show page must be not found', function () {

    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin)
        ->get(route('users.show', ['user' => 1]))
        ->assertNotFound();
});

test('edit page must be not found', function () {

    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin)
        ->get(route('users.edit', ['user' => 1]))
        ->assertNotFound();
});

test('admin can update user', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin)
        ->put(route('users.update', ['user' => 1]), [
            'name'                  => 'Test Update User',
            'role'                  => 'staff',
        ])
        ->assertRedirectToRoute('users.index')
        ->assertSessionHas('success', 'User berhasil diupdate.');

    assertDatabaseHas('users', [
        'name'      => 'Test Update User',
        'role'      => 'staff',
    ]);
});

test('staff can not update user', function () {
    $staff = User::factory()->create(['role' => 'staff']);

    actingAs($staff)
        ->put(route('users.update', ['user' => 1]), [
            'name'                  => 'Test Update User',
            'role'                  => 'staff',
        ])
        ->assertForbidden();

    assertDatabaseMissing('users', [
        'name'      => 'Test Update User',
        'role'      => 'staff',
    ]);
});

test('admin can delete user', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $user = User::factory()->create([
        'name'      => 'Test User',
        'email'     => 'test@example.com',
        'role'      => 'admin',
    ]);

    actingAs($admin)
        ->delete(route('users.destroy', ['user' => $user->id]))
        ->assertRedirectToRoute('users.index')
        ->assertSessionHas('success', 'User berhasil dihapus.');

    assertDatabaseMissing('users', [
        'name'      => 'Test User',
        'email'     => 'test@example.com',
        'role'      => 'admin',
    ]);
});

test('staff can not delete user', function () {
    $staff = User::factory()->create(['role' => 'staff']);

    $user = User::factory()->create([
        'name'      => 'Test User',
        'email'     => 'test@example.com',
        'role'      => 'staff',
    ]);

    actingAs($staff)
        ->delete(route('users.destroy', ['user' => $user->id]))
        ->assertForbidden();

    assertDatabaseHas('users', [
        'name'      => 'Test User',
        'email'     => 'test@example.com',
        'role'      => 'staff',
    ]);
});

test('admin can force reset user password', function () {

    $admin = User::factory()->create(['role' => 'admin']);

    $user = User::factory()->create([
        'name'      => 'Test User',
        'email'     => 'test@example.com',
        'password'  => Hash::make('password'),
        'role'      => 'staff',
    ]);

    actingAs($admin)
        ->patch(route('users.reset-password', ['user' => $user->id]), [
            'password'              => 'new password',
            'password_confirmation' => 'new password',
        ])
        ->assertRedirectToRoute('users.index')
        ->assertSessionHas('success', 'Password berhasil direset.');

    $user->refresh();

    expect(Hash::check('new password', $user->password))->toBeTrue();
});
