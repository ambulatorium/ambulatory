<?php

namespace Reliqui\Ambulatory\Tests\Feature\Settings;

use Illuminate\Support\Arr;
use Reliqui\Ambulatory\User;
use Reliqui\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateAccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_may_can_not_update_the_account()
    {
        $this->patchJson(route('ambulatory.account.update'), [])->assertStatus(401);
    }

    /** @test */
    public function a_user_can_get_the_details_about_their_account()
    {
        $user = $this->signInAsPatient();

        $this->getJson(route('ambulatory.account.show'))
            ->assertOk()
            ->assertExactJson([
                'entry' => Arr::only($user->toArray(), ['id', 'name', 'email', 'avatar']),
            ]);
    }

    /** @test */
    public function a_user_can_update_their_account()
    {
        $this->signInAsPatient();

        $this->patchJson(route('ambulatory.account.update'), factory(User::class)->raw([
                'name' => 'name changed',
            ]))->assertOk();

        $this->assertDatabaseHas('reliqui_users', ['name' => 'name changed']);
    }

    /** @test */
    public function a_user_email_is_required()
    {
        $this->signInAsPatient();

        $this->patchJson(route('ambulatory.account.update'), factory(User::class)->raw([
                'email' => ''
            ]))
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'email' => ['The email field is required.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }

    /** @test */
    public function a_user_name_is_required()
    {
        $this->signInAsPatient();

        $this->patchJson(route('ambulatory.account.update'), factory(User::class)->raw([
                'name' => ''
            ]))
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'name' => ['The name field is required.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }
}
