<?php

namespace Ambulatory\Tests\Feature;

use Ambulatory\HealthFacility;
use Ambulatory\Schedule;
use Ambulatory\Tests\TestCase;
use Ambulatory\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ManageScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_doctor_schedule()
    {
        $schedule = factory(Schedule::class)->create();

        $this->getJson(route('ambulatory.schedules'))->assertStatus(401);
        $this->postJson(route('ambulatory.schedules.store'), [])->assertStatus(401);
        $this->getJson(route('ambulatory.schedules.show', $schedule->id))->assertStatus(401);
        $this->patchJson(route('ambulatory.schedules.update', $schedule->id), [])->assertStatus(401);
    }

    /** @test */
    public function unauthorized_users_cannot_create_a_new_schedule()
    {
        $this->signInAsAdmin();
        $this->postJson(route('ambulatory.schedules.store'), [])->assertStatus(403);

        $this->signInAsPatient();
        $this->postJson(route('ambulatory.schedules.store'), [])->assertStatus(403);
    }

    /** @test */
    public function a_doctor_only_get_their_schedules()
    {
        $this->signInAsDoctor();

        $schedule = factory(Schedule::class)->create();

        $this->getJson(route('ambulatory.schedules'))
            ->assertOk()
            ->assertJson([
                'data' => [],
            ]);

        $this
            ->actingAs($schedule->doctor->user)
            ->getJson(route('ambulatory.schedules'))
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'start_date' => $schedule->start_date->jsonSerialize(),
                        'end_date' => $schedule->end_date->jsonSerialize(),
                        'estimated_service_time_in_minutes' => $schedule->estimated_service_time_in_minutes,
                        'health_facility' => [
                            'id' => $schedule->healthFacility->id,
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    public function unverified_doctor_can_not_create_a_new_schedule()
    {
        $user = factory(User::class)->create(['type' => User::DOCTOR]);

        $this
            ->actingAs($user, 'ambulatory')
            ->postJson(route('ambulatory.schedules.store'), [])
            ->assertStatus(403)
            ->assertExactJson([
                'message' => 'Please verify your doctor profile first',
            ]);
    }

    /** @test */
    public function verified_doctor_can_create_a_new_schedule()
    {
        $this->signInAsDoctor();

        $this->postJson(route('ambulatory.schedules.store'), $attributes = $this->scheduleAttributes())
            ->assertStatus(201)
            ->assertJson([
                'start_date' => Carbon::parse($attributes['start_date'])->jsonSerialize(),
                'end_date' => Carbon::parse($attributes['end_date'])->jsonSerialize(),
            ]);

        $this->assertDatabaseHas('ambulatory_schedules', [
            'doctor_id' => auth('ambulatory')->user()->doctorProfile->id,
            'health_facility_id' => $attributes['health_facility']['id'],
        ]);
    }

    /** @test */
    public function included_a_health_facility_should_be_exists()
    {
        $this->signInAsDoctor();

        $healthFacility = factory(HealthFacility::class)->raw(['id' => (string) Str::uuid()]);

        $this->postJson(route('ambulatory.schedules.store'), $attributes = $this->scheduleAttributes([
            'health_facility' => $healthFacility,
        ]))
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'health_facility.id' => ['The selected Health facility is invalid.'],
                ],
                'message' => 'The given data was invalid.',
            ]);

        $this->assertDatabaseMissing('ambulatory_schedules', [
            'start_date' => $attributes['start_date'],
            'end_date' => $attributes['end_date'],
        ]);
    }

    /** @test */
    public function included_a_health_facility_is_unique_with_doctor()
    {
        $schedule = factory(Schedule::class)->create();

        $this
            ->actingAs($schedule->doctor->user, 'ambulatory')
            ->postJson(route('ambulatory.schedules.store'), $this->scheduleAttributes([
                'health_facility' => $schedule->healthFacility->toArray(),
            ]))
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'health_facility.id' => ['The Health facility has already been taken.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }

    /** @test */
    public function start_date_should_be_after_or_equal_to_today()
    {
        $this->signInAsDoctor();

        $this->postJson(route('ambulatory.schedules.store'), $this->scheduleAttributes([
            'start_date' => today()->yesterday()->toDateString(),
        ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors('start_date')
            ->assertExactJson([
                'errors' => [
                    'start_date' => ['The start date must be a date after or equal to '.today()->toDateString().'.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }

    /** @test */
    public function end_date_should_be_after_from_the_start_date()
    {
        $this->signInAsDoctor();

        $this->postJson(route('ambulatory.schedules.store'), $this->scheduleAttributes([
            'end_date' => today()->yesterday()->toDateString(),
        ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors('end_date')
            ->assertExactJson([
                'errors' => [
                    'end_date' => ['The end date must be a date after start date.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }

    /** @test */
    public function a_doctor_can_get_their_details_of_schedule()
    {
        $schedule = factory(Schedule::class)->create();

        $this
            ->actingAs($schedule->doctor->user, 'ambulatory')
            ->getJson(route('ambulatory.schedules.show', $schedule->id))
            ->assertOk()
            ->assertJson([
                'start_date' => $schedule->start_date->jsonSerialize(),
                'end_date' => $schedule->end_date->jsonSerialize(),
                'estimated_service_time_in_minutes' => $schedule->estimated_service_time_in_minutes,
                'health_facility' => [
                    'id' => $schedule->healthFacility->id,
                ],
            ]);
    }

    /** @test */
    public function a_doctor_can_not_get_the_details_schedule_of_others()
    {
        $this->signInAsDoctor();

        $schedule = factory(Schedule::class)->create();

        $this->getJson(route('ambulatory.schedules.show', $schedule->id))->assertStatus(403);
    }

    /** @test */
    public function a_doctor_can_not_update_the_schedule_of_others()
    {
        $this->signInAsDoctor();

        $schedule = factory(Schedule::class)->create();

        $this->patchJson(route('ambulatory.schedules.update', $schedule->id), $this->scheduleAttributes())
            ->assertStatus(403)
            ->assertExactJson([
                'message' => 'This action is unauthorized.',
            ]);
    }

    /** @test */
    public function a_doctor_can_update_their_schedule()
    {
        $schedule = factory(Schedule::class)->create();

        $this
            ->actingAs($schedule->doctor->user, 'ambulatory')
            ->patchJson(route('ambulatory.schedules.update', $schedule->id), $attributes = $this->scheduleAttributes())
            ->assertOk()
            ->assertJson([
                'id' => $schedule->id,
            ]);

        $this->assertNotSame($schedule->health_facility_id, $attributes['health_facility']['id']);

        $this->assertDatabaseHas('ambulatory_schedules', [
            'health_facility_id' => $attributes['health_facility']['id'],
        ]);
    }

    protected function scheduleAttributes($overrides = [])
    {
        $location = factory(HealthFacility::class)->create();

        $attributes = factory(Schedule::class)->raw(array_merge([
            'health_facility' => $location->toArray(),
        ], $overrides));

        return Arr::except($attributes, ['health_facility_id', 'doctor_id']);
    }
}
