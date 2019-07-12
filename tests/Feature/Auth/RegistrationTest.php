<?php

namespace Ambulatory\Tests\Feature\Auth;

Use Ambulatory\User;
use Illuminate\Support\Facades\Hash;
Use Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_register_an_account()
    {
        $response = $this->post(route('ambulatory.register.attempt'), [
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $response->assertRedirect(config('ambulatory.path'));

        $this->assertTrue(auth('ambulatory')->check());
        $this->assertCount(1, User::all());

        tap(User::first(), function ($user) {
            $this->assertEquals('Jane Doe', $user->name);
            $this->assertEquals('janedoe@example.com', $user->email);
            $this->assertTrue(Hash::check('secret', $user->password));
        });
    }

    /** @test */
    public function the_name_is_required()
    {
        $this->from(route('ambulatory.register'));

        $response = $this->post(route('ambulatory.register.attempt'), $this->guestData([
            'name' => '',
        ]));

        $response->assertRedirect(route('ambulatory.register'));
        $response->assertSessionHasErrors('name');

        $this->assertFalse(auth('ambulatory')->check());
        $this->assertCount(0, User::all());
    }

    /** @test */
    public function the_email_is_required()
    {
        $this->from(route('ambulatory.register'));

        $response = $this->post(route('ambulatory.register.attempt'), $this->guestData([
            'email' => '',
        ]));

        $response->assertRedirect(route('ambulatory.register'));
        $response->assertSessionHasErrors('email');

        $this->assertFalse(auth('ambulatory')->check());
        $this->assertCount(0, User::all());
    }

    /** @test */
    public function the_email_is_unique()
    {
        factory(User::class)->create(['email' => 'janedoe@example.com']);

        $this->from(route('ambulatory.register'));

        $response = $this->post(route('ambulatory.register.attempt'), $this->guestData([
            'email' => 'janedoe@example.com',
        ]));

        $response->assertRedirect(route('ambulatory.register'));
        $response->assertSessionHasErrors('email');

        $this->assertFalse(auth('ambulatory')->check());
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function the_password_is_required()
    {
        $this->from(route('ambulatory.register'));

        $response = $this->post(route('ambulatory.register.attempt'), $this->guestData([
            'password' => '',
        ]));

        $response->assertRedirect(route('ambulatory.register'));
        $response->assertSessionHasErrors('password');

        $this->assertFalse(auth('ambulatory')->check());
        $this->assertCount(0, User::all());
    }

    /** @test */
    public function the_password_must_be_min_6_chars()
    {
        $this->from(route('ambulatory.register'));

        $response = $this->post(route('ambulatory.register.attempt'), $this->guestData([
            'password' => 'fooba',
            'password_confirmation' => 'fooba',
        ]));

        $response->assertRedirect(route('ambulatory.register'));
        $response->assertSessionHasErrors('password');

        $this->assertFalse(auth('ambulatory')->check());
        $this->assertCount(0, User::all());
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
        $this->from(route('ambulatory.register'));

        $response = $this->post(route('ambulatory.register.attempt'), $this->guestData([
            'password' => 'foo',
            'password_confirmation' => 'bar',
        ]));

        $response->assertRedirect(route('ambulatory.register'));
        $response->assertSessionHasErrors('password');

        $this->assertFalse(auth('ambulatory')->check());
        $this->assertCount(0, User::all());
    }

    private function guestData($overrides = [])
    {
        return array_merge([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ], $overrides);
    }
}
