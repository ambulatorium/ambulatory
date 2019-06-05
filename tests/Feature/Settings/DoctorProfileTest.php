<?php

namespace Reliqui\Ambulatory\Tests\Feature\Settings;

use Reliqui\Ambulatory\User;
use Reliqui\Ambulatory\Doctor;
use Reliqui\Ambulatory\Specialization;
use Reliqui\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthorized_users_can_not_manage_the_doctor_profile()
    {
        tap($this->signInAsAdmin(), function () {
            $this->getJson(route('ambulatory.doctor-profile.show'))->assertStatus(403);
            $this->postJson(route('ambulatory.doctor-profile.store'), [])->assertStatus(403);
            $this->patchJson(route('ambulatory.doctor-profile.update'), [])->assertStatus(403);
        });

        tap($this->signInAsPatient(), function () {
            $this->getJson(route('ambulatory.doctor-profile.show'))->assertStatus(403);
            $this->postJson(route('ambulatory.doctor-profile.store'), [])->assertStatus(403);
            $this->patchJson(route('ambulatory.doctor-profile.update'), [])->assertStatus(403);
        });
    }

    /** @test */
    public function unverified_doctor_just_get_their_empty_profile()
    {
        $user = factory(User::class)->create(['type' => User::DOCTOR]);

        $this->actingAs($user, 'ambulatory')
            ->getJson(route('ambulatory.doctor-profile.show'))
            ->assertOk()
            ->assertExactJson([
                'entry' => [],
            ]);
    }

    /** @test */
    public function verified_doctor_can_get_their_entry_profile()
    {
        $this->signInAsDoctor();

        $this->getJson(route('ambulatory.doctor-profile.show'))
            ->assertOk()
            ->assertExactJson([
                'entry' => auth('ambulatory')->user()->doctorProfile->toArray(),
            ]);
    }

    /** @test */
    public function user_as_a_doctor_can_create_their_new_profile()
    {
        $user = factory(User::class)->create(['type' => User::DOCTOR]);

        $this
            ->actingAs($user, 'ambulatory')
            ->postJson(route('ambulatory.doctor-profile.store'), factory(Doctor::class)->raw([
                'specializations' => factory(Specialization::class)->create()->toArray(),
            ]))
            ->assertOk()
            ->assertExactJson([
                'entry' => $user->doctorProfile->toArray(),
            ]);

        $this->assertTrue($user->isVerifiedDoctor());

        $this->assertDatabaseHas('reliqui_doctors', $user->doctorProfile->toArray());
    }

    /** @test */
    public function a_doctor_can_update_their_profile()
    {
        $this->signInAsDoctor();

        $user = auth('ambulatory')->user();

        $this->patchJson(route('ambulatory.doctor-profile.update'), factory(Doctor::class)->raw([
                'full_name' => 'Full Name Changed',
                'specializations' => factory(Specialization::class)->create()->toArray(),
                'user_id' => $user->id,
            ]))
            ->assertOk()
            ->assertExactJson([
                'entry' => $user->doctorProfile->toArray(),
            ]);

        $this->assertSame($user->doctorProfile->slug, 'full-name-changed');

        $this->assertDatabaseHas('reliqui_doctors', $user->doctorProfile->toArray());
    }

    /** @test */
    public function a_doctor_profile_requires_specializations()
    {
        $user = factory(User::class)->create(['type' => User::DOCTOR]);

        $this->actingAs($user, 'ambulatory')
            ->postJson(route('ambulatory.doctor-profile.store'), factory(Doctor::class)->raw())
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'specializations' => ['The specializations field is required.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }

    /** @test */
    public function included_the_specializations_should_be_exists()
    {
        $user = factory(User::class)->create(['type' => User::DOCTOR]);

        $this->actingAs($user, 'ambulatory')
            ->postJson(route('ambulatory.doctor-profile.store'), factory(Doctor::class)->raw([
                'specializations' => factory(Specialization::class)->raw(['id' => 'fake-id']),
            ]))
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'specializations.id' => ['The selected specializations.id is invalid.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }
}
