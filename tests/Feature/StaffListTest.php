<?php

namespace Ambulatory\Tests\Feature;

use Ambulatory\User;
use Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StaffListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_not_get_the_staff_list()
    {
        $this->getJson(route('ambulatory.staff'))->assertStatus(401);
    }

    /** @test */
    public function unauthorized_users_cannot_get_the_staff_list()
    {
        $this->signInAsDoctor();
        $this->getJson(route('ambulatory.staff'))->assertStatus(403);

        $this->signInAsPatient();
        $this->getJson(route('ambulatory.staff'))->assertStatus(403);
    }

    /** @test */
    public function admin_can_get_the_staff_list()
    {
        $this->signInAsAdmin();

        $staff = factory(User::class)->create(['type' => User::ADMIN]);

        $notStaff = factory(User::class)->create();

        $this->getJson(route('ambulatory.staff'))
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'id' => auth('ambulatory')->id(),
                    ],
                    [
                        'id' => $staff->id,
                    ],
                ],
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'id' => $notStaff->id,
                    ],
                ],
            ])
            ->assertJsonCount(3); // data, links, meta
    }
}
