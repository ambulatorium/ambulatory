<?php

namespace Ambulatory\Tests\Feature\Auth;

use Ambulatory\Tests\TestCase;
use Ambulatory\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_with_their_correct_credentials()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make($password = 'secret'),
        ]);

        $this->post(route('ambulatory.login.attempt'), [
            'email' => $user->email,
            'password' => $password,
        ])->assertRedirect(config('ambulatory.path'));

        $this->assertTrue(auth('ambulatory')->check());
    }

    /** @test */
    public function user_cannot_login_with_incorrect_email()
    {
        $this->from(route('ambulatory.login'))
            ->post(route('ambulatory.login.attempt'), [
                'email' => 'invalid@example.com',
                'password' => 'invalid-password',
            ])
            ->assertRedirect(route('ambulatory.login'))
            ->assertSessionHasErrors('email');

        $this->assertFalse(auth('ambulatory')->check());
    }

    /** @test */
    public function user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('secret'),
        ]);

        $this->from(route('ambulatory.login'))
            ->post(route('ambulatory.login.attempt'), [
                'email' => $user->email,
                'password' => 'not-secret',
            ])
            ->assertRedirect(route('ambulatory.login'));

        $this->assertFalse(auth('ambulatory')->check());
    }

    /** @test */
    public function user_can_logout()
    {
        $this->signInAsPatient();

        $this->get(route('ambulatory.logout'))
            ->assertRedirect(route('ambulatory.login'))
            ->assertSessionHas('loggedOut', true);

        $this->assertFalse(auth('ambulatory')->check());
    }
}
