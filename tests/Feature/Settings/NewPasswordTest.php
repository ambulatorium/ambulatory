<?php

namespace Reliqui\Ambulatory\Tests\Feature\Settings;

use Reliqui\Ambulatory\User;
use Illuminate\Support\Facades\Hash;
use Reliqui\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_cannot_update_the_password()
    {
        $this->patchJson(route('ambulatory.new-password'))->assertStatus(401);
    }

    /** @test */
    public function the_current_password_is_required()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user, 'ambulatory')
            ->patchJson(route('ambulatory.new-password'), $this->credentials([
                'current_password' => '',
            ]))
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'current_password' => ['The current password field is required.'],
                ],
            ]);
    }

    /** @test */
    public function the_current_password_must_be_min_6_chars_and_already_exist()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user, 'ambulatory')
            ->patchJson(route('ambulatory.new-password'), $this->credentials([
                'current_password' => 'secr',
            ]))
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'current_password' => [
                        'The current password must be at least 6 characters.',
                        'Your current password is incorrect.',
                    ],
                ],
            ]);
    }

    /** @test */
    public function the_new_password_is_required()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user, 'ambulatory')
            ->patchJson(route('ambulatory.new-password'), $this->credentials([
                'new_password' => '',
            ]))
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'new_password' => ['The new password field is required.'],
                ],
            ]);
    }

    /** @test */
    public function the_new_password_must_be_min_6_chars()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user, 'ambulatory')
            ->patchJson(route('ambulatory.new-password'), $this->credentials([
                'new_password' => 'secr',
            ]))
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'new_password' => ['The new password must be at least 6 characters.'],
                ],
            ]);
    }

    /** @test */
    public function the_confirm_new_password_is_required()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user, 'ambulatory')
            ->patchJson(route('ambulatory.new-password'), $this->credentials([
                'confirm_new_password' => '',
            ]))
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'confirm_new_password' => ['The confirm new password field is required.'],
                ],
            ]);
    }

    /** @test */
    public function the_confirm_new_password_must_be_min_6_chars()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user, 'ambulatory')
            ->patchJson(route('ambulatory.new-password'), $this->credentials([
                'confirm_new_password' => 'secr',
            ]))
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'confirm_new_password' => ['The confirm new password must be at least 6 characters.'],
                ],
            ]);
    }

    /** @test */
    public function the_confirm_new_password_should_match_to_the_new_password()
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user, 'ambulatory')
            ->patchJson(route('ambulatory.new-password'), $this->credentials([
                'confirm_new_password' => 'secretss',
            ]))
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'confirm_new_password' => ['Password confirmation should match to the new password'],
                ],
            ]);
    }

    /** @test */
    public function user_can_update_their_password()
    {
        $user = factory(User::class)->create(['password' => Hash::make('low-secret')]);

        $this
            ->actingAs($user, 'ambulatory')
            ->patchJson(route('ambulatory.new-password'), $this->credentials([
                'current_password' => 'low-secret',
            ]))
            ->assertOk();

        $this->assertTrue(auth('ambulatory')->check());
        $this->assertCount(1, User::all());

        tap(User::first(), function ($user) {
            $this->assertFalse(Hash::check('low-secret', $user->password));
            $this->assertTrue(Hash::check('super-secrets', $user->password));
        });
    }

    protected function credentials($overrides = [])
    {
        return array_merge([
            'current_password' => 'secret',
            'new_password' => 'super-secrets',
            'confirm_new_password' => 'super-secrets',
        ], $overrides);
    }
}
