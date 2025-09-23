<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_user_can_view_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('user.profile'));

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    public function test_user_can_view_edit_profile_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('user.edit'));

        $response->assertStatus(200);
        $response->assertSee('Edit Profile');
    }

    public function test_user_can_update_profile(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        $response = $this->actingAs($user)->put(route('user.update'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect(route('user.profile'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('new@example.com', $user->email);
    }

    public function test_user_can_update_profile_with_photo(): void
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('profile.jpg');

        $response = $this->actingAs($user)->put(route('user.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'profile_photo' => $file,
        ]);

        $response->assertRedirect(route('user.profile'));
        $user->refresh();

        $this->assertNotNull($user->profile_photo_path);
        Storage::disk('public')->assertExists($user->profile_photo_path);
    }

    public function test_user_can_change_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('old-password'),
        ]);

        $response = $this->actingAs($user)->put(route('user.update-password'), [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect(route('user.profile'));
        $response->assertSessionHas('success');
    }

    public function test_user_cannot_change_password_with_wrong_current_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->actingAs($user)->put(route('user.update-password'), [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors(['current_password']);
    }

    public function test_user_can_view_orders(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('user.orders'));

        $response->assertStatus(200);
        $response->assertSee('Order History');
    }

    public function test_user_can_view_delete_account_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('user.delete-account'));

        $response->assertStatus(200);
        $response->assertSee('Delete Account');
    }

    public function test_user_can_delete_account(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->delete(route('user.destroy'), [
            'password' => 'password',
            'confirmation' => 'DELETE',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_user_cannot_delete_account_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->actingAs($user)->delete(route('user.destroy'), [
            'password' => 'wrong-password',
            'confirmation' => 'DELETE',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
