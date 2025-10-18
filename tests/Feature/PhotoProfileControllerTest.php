<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('user can upload photo profile', function () {
    /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
    $storage = Storage::fake('public');

    $user = User::factory()->create();

    $photo = UploadedFile::fake()->image('profile.png', 100, 100);

    $response = actingAs($user)
        ->post(route('profile.photo.store'), [
            'photo' => $photo
        ]);

    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
        'message' => 'Foto profil berhasil diubah',
    ]);

    $storage->assertExists('profile/' . $photo->hashName());

    $user->refresh();
    expect($user->photo)->toBe('storage/profile/' . $photo->hashName());
});

test('user can delete photo profile', function () {
    /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
    $storage = Storage::fake('public');

    $user = User::factory()->create();

    $photo = UploadedFile::fake()->image('profile.png', 100, 100);

    $user->update([
        'photo' => 'storage/profile/' . $photo->hashName()
    ]);

    $response = actingAs($user)
        ->delete(route('profile.photo.destroy'));

    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
        'message' => 'Foto profil berhasil dihapus',
    ]);

    $storage->assertMissing('profile/' . $photo->hashName());

    $user->refresh();
    expect($user->photo)->toBeNull();
});

test('user can not upload photo profile greater than 2mb', function () {
    /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
    $storage = Storage::fake('public');

    $user = User::factory()->create([
        'photo' => null
    ]);

    $photo = UploadedFile::fake()->create('profile.png', 3000, 'image/png');

    $response = actingAs($user)
        ->post(route('profile.photo.store'), [
            'photo' => $photo
        ]);

    $response->assertStatus(302);
    $response->assertSessionHasErrors('photo');

    $storage->assertMissing('profile/' . $photo->hashName());

    $user->refresh();
    expect($user->photo)->toBeNull();
});

test('user can not delete photo profile when no photo profile', function () {
    $user = User::factory()->create([
        'photo' => null
    ]);

    $response = actingAs($user)
        ->delete(route('profile.photo.destroy'));

    $response->assertStatus(400);
    $response->assertJson([
        'success' => false,
        'message' => 'Foto profil gagal dihapus',
    ]);

    $user->refresh();
    expect($user->photo)->toBeNull();
});

test('user can not upload photo profile when not authenticated', function () {

    $photo = UploadedFile::fake()->image('profile.png', 100, 100);

    $response = $this->postJson(route('profile.photo.store'), [
        'photo' => $photo
    ]);

    $response->assertStatus(401);
});
