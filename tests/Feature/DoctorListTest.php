<?php

namespace Ambulatory\Tests\Feature;

use Ambulatory\Doctor;
use Illuminate\Support\Arr;
use Ambulatory\Tests\TestCase;
use Ambulatory\Http\Resources\DoctorResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

// @todo complete the resource test.
class DoctorListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_not_get_the_doctor_list()
    {
        $this->getJson(route('ambulatory.doctors'))->assertStatus(401);
    }

    /** @test */
    public function guest_can_not_get_the_profile_of_doctor()
    {
        $doctor = factory(Doctor::class)->create();

        $this->getJson(route('ambulatory.doctors.show', $doctor->id))->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_can_get_the_doctor_list()
    {
        $this->signInAsPatient();

        factory(Doctor::class, 2)->create();

        $resource = DoctorResource::collection(Doctor::with('user', 'specializations')->latest()->paginate(25));

        $this->getJson(route('ambulatory.doctors'))
            ->assertOk()
            ->assertJson(Arr::except($resource->response()->getData(true), ['meta', 'links']))
            ->assertJsonCount(3); // data, meta, links
    }

    /** @test */
    public function authenticated_user_can_get_the_profile_of_doctor()
    {
        $this->signInAsPatient();

        $doctor = factory(Doctor::class)->create();

        $resource = (new DoctorResource($doctor->fresh()->load('user', 'specializations', 'schedules')));

        $this->getJson(route('ambulatory.doctors.show', $doctor->id))
            ->assertOk()
            ->assertExactJson($resource->response()->getData(true));
    }
}
