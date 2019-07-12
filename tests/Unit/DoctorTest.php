<?php

namespace Ambulatory\Tests\Unit;

use Ambulatory\User;
use Ambulatory\Doctor;
use Ambulatory\Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_uuid_when_creating_a_new_profile()
    {
        $doctor = factory(Doctor::class)->create();

        $this->assertNotNull($doctor->id);
    }

    /** @test */
    public function it_generate_the_slug_when_saving_a_new_profile()
    {
        $doctor = factory(Doctor::class)->create(['full_name' => 'David H Sianturi']);

        $this->assertSame('david-h-sianturi', $doctor->slug);

        $doctor = factory(Doctor::class)->create(['full_name' => 'David H Sianturi']);

        $this->assertSame('david-h-sianturi-0', $doctor->slug);
    }

    /** @test */
    public function it_generate_the_slug_with_a_full_name_that_ends_in_a_number()
    {
        $doctor = factory(Doctor::class)->create(['full_name' => 'David H Sianturi 18']);

        $this->assertSame('david-h-sianturi-18', $doctor->slug);

        $doctor = factory(Doctor::class)->create(['full_name' => 'David H Sianturi 18']);

        $this->assertSame('david-h-sianturi-18-0', $doctor->slug);
    }

    /** @test */
    public function it_has_specializations()
    {
        $doctor = factory(Doctor::class)->create();

        $this->assertInstanceOf(Collection::class, $doctor->specializations);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $doctor = factory(Doctor::class)->create();

        $this->assertInstanceOf(User::class, $doctor->user);

        $this->assertSame($doctor->user->type(), User::DOCTOR);
        $this->assertTrue($doctor->user->isVerifiedDoctor());
    }

    /** @test */
    public function it_has_schedules()
    {
        $doctor = factory(Doctor::class)->create();

        $this->assertInstanceOf(Collection::class, $doctor->schedules);
    }

    /** @test */
    public function it_has_appointments()
    {
        $doctor = factory(Doctor::class)->create();

        $this->assertInstanceOf(Collection::class, $doctor->appointments);
    }
}
