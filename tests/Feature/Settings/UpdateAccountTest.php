<?php

namespace Ambulatory\Tests\Feature\Settings;

use Ambulatory\User;
use Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateAccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_may_cannot_update_the_account()
    {
        $this->patchJson(route('ambulatory.account'), [])->assertStatus(401);
    }

    /** @test */
    public function a_user_can_get_the_details_about_their_account()
    {
        $auth = $this->signInAsPatient();

        $this->getJson(route('ambulatory.account'))
            ->assertOk()
            ->assertExactJson([
                'id' => $auth->id,
                'name' => $auth->name,
                'avatar' => $auth->avatar,
                'role' => $auth->role,
                'created_at' => $auth->created_at,
                'updated_at' => $auth->updated_at,
            ]);
    }

    /** @test */
    public function a_user_cannot_get_the_details_account_of_others()
    {
        $this->signInAsPatient();

        $otherUser = factory(User::class)->create();

        $this->getJson(route('ambulatory.account'))
            ->assertOk()
            ->assertJsonMissing([
                'id' => $otherUser->id,
                'name' => $otherUser->name,
                'avatar' => $otherUser->avatar,
            ]);
    }

    /** @test */
    public function a_user_can_update_their_account()
    {
        $user = $this->signInAsPatient();

        $this->patchJson(route('ambulatory.account'), $attributes = [
                'name' => 'name changed',
                'email' => $user->email,
                'avatar' => $user->avatar,
            ])
            ->assertOk()
            ->assertJson([
                'id' => $user->id,
                'name' => 'name changed',
                'avatar' => $user->avatar,
            ]);

        $this->assertDatabaseHas('ambulatory_users', $attributes);
    }

    /** @test */
    public function a_user_email_is_required()
    {
        $this->signInAsPatient();

        $this->patchJson(route('ambulatory.account'), factory(User::class)->raw([
                'email' => '',
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

        $this->patchJson(route('ambulatory.account'), factory(User::class)->raw([
                'name' => '',
            ]))
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'name' => ['The name field is required.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }

    /** @test */
    public function a_user_avatar_is_required()
    {
        $this->signInAsPatient();

        $this->patchJson(route('ambulatory.account'), factory(User::class)->raw([
                'avatar' => '',
            ]))
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'avatar' => ['The avatar field is required.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }
}
