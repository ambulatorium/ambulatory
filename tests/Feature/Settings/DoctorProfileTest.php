<?php

namespace Ambulatory\Tests\Feature\Settings;

use Ambulatory\User;
use Ambulatory\Doctor;
use Ambulatory\Specialization;
use Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthorized_users_can_not_manage_the_doctor_profile()
    {
        $doctor = factory(Doctor::class)->create();

        tap($this->signInAsAdmin(), function () use ($doctor) {
            $this->getJson(route('ambulatory.doctor-profile.show', $doctor->id))->assertStatus(403);
            $this->postJson(route('ambulatory.doctor-profile.store'), [])->assertStatus(403);
            $this->patchJson(route('ambulatory.doctor-profile.update', $doctor->id), [])->assertStatus(403);
        });

        tap($this->signInAsPatient(), function () use ($doctor) {
            $this->getJson(route('ambulatory.doctor-profile.show', $doctor->id))->assertStatus(403);
            $this->postJson(route('ambulatory.doctor-profile.store'), [])->assertStatus(403);
            $this->patchJson(route('ambulatory.doctor-profile.update', $doctor->id), [])->assertStatus(403);
        });
    }

    /** @test */
    public function user_as_a_doctor_can_create_their_new_profile()
    {
        $user = factory(User::class)->create(['type' => User::DOCTOR]);

        $this
            ->actingAs($user, 'ambulatory')
            ->postJson(route('ambulatory.doctor-profile.store'), factory(Doctor::class)->raw([
                'specializations' => factory(Specialization::class, 1)->create(),
            ]))
            ->assertOk()
            ->assertExactJson([
                'entry' => $user->doctorProfile->toArray(),
            ]);

        $this->assertTrue($user->isVerifiedDoctor());

        $this->assertDatabaseHas('ambulatory_doctors', $user->doctorProfile->toArray());
    }

    /** @test */
    public function a_doctor_can_not_update_doctor_profile_of_others()
    {
        $this->signInAsDoctor();

        $doctor = factory(Doctor::class)->create();

        $this->patchJson(route('ambulatory.doctor-profile.update', $doctor->id), factory(Doctor::class)->raw([
                'full_name' => 'Full Name Changed',
                'specializations' => factory(Specialization::class, 1)->create(),
            ]))
            ->assertStatus(403)
            ->assertExactJson([
                'message' => 'This action is unauthorized.',
            ]);
    }

    /** @test */
    public function a_doctor_can_update_their_profile()
    {
        $this->signInAsDoctor();

        $user = auth('ambulatory')->user();

        $this->patchJson(route('ambulatory.doctor-profile.update', $user->doctorProfile->id), factory(Doctor::class)->raw([
                'full_name' => 'Full Name Changed',
                'specializations' => factory(Specialization::class, 1)->create(),
            ]))
            ->assertOk()
            ->assertExactJson([
                'entry' => $user->doctorProfile->fresh()->toArray(),
            ]);

        tap($user->doctorProfile->fresh(), function ($doctor) {
            $this->assertSame($doctor->slug, 'full-name-changed');

            $this->assertDatabaseHas('ambulatory_doctors', $doctor->toArray());
        });
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
                'specializations' => factory(Specialization::class, 1)->raw(['id' => 'fake-id']),
            ]))
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'specializations.0.id' => ['The selected specializations.0.id is invalid.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }
}
