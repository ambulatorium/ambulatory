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
        $this->patchJson(route('ambulatory.account.update', 'fake-id'), [])->assertStatus(401);
    }

    /** @test */
    public function a_user_can_get_the_details_about_their_account()
    {
        $auth = $this->signInAsPatient();

        $this->getJson(route('ambulatory.account.show', $auth->id))
            ->assertOk()
            ->assertExactJson([
                'entry' => Arr::only($auth->toArray(), ['id', 'name', 'email', 'avatar']),
            ]);
    }

    /** @test */
    public function a_user_can_not_get_the_details_account_of_others()
    {
        $this->signInAsPatient();

        $otherUser = factory(User::class)->create();

        $this->getJson(route('ambulatory.account.show', $otherUser->id))
            ->assertStatus(404)
            ->assertExactJson([
                'message' => '',
            ]);
    }

    /** @test */
    public function a_user_can_update_their_account()
    {
        $this->signInAsPatient();

        $this->patchJson(route('ambulatory.account.update', auth('ambulatory')->id()),
            $attributes = factory(User::class)->raw([
                'name' => 'name changed',
            ]))
            ->assertOk();

        $this->assertDatabaseHas('ambulatory_users', Arr::except($attributes, ['id', 'password']));
    }

    /** @test */
    public function a_user_can_not_update_account_of_others()
    {
        $this->signInAsPatient();

        $otherUser = factory(User::class)->create();

        $this->patchJson(route('ambulatory.account.update', $otherUser->id),
            $attributes = factory(User::class)->raw([
                'name' => 'name changed',
            ]))
            ->assertStatus(404)
            ->assertExactJson([
                'message' => '',
            ]);

        $this->assertDatabaseMissing('ambulatory_users', Arr::except($attributes, ['id', 'password']));
    }

    /** @test */
    public function a_user_email_is_required()
    {
        $this->signInAsPatient();

        $this->patchJson(route('ambulatory.account.update', auth('ambulatory')->id()), factory(User::class)->raw([
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

        $this->patchJson(route('ambulatory.account.update', auth('ambulatory')->id()), factory(User::class)->raw([
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

        $this->patchJson(route('ambulatory.account.update', auth('ambulatory')->id()), factory(User::class)->raw([
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
