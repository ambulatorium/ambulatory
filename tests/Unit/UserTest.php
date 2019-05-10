<?php

namespace Reliqui\Ambulatory\Tests\Unit;

use Reliqui\Ambulatory\User;
use Reliqui\Ambulatory\Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_with_type_patient_should_has_role_as_a_patient()
    {
        $user = factory(User::class)->create(['type' => User::PATIENT]);

        $this->assertTrue($user->isPatient());
        $this->assertSame('patient', $user->role);
    }

    /** @test */
    public function a_user_with_type_doctor_should_has_role_as_a_doctor()
    {
        $user = factory(User::class)->create(['type' => User::DOCTOR]);

        $this->assertTrue($user->isDoctor());
        $this->assertSame('doctor', $user->role);
    }

    /** @test */
    public function a_user_with_type_admin_should_has_role_as_an_admin()
    {
        $user = factory(User::class)->create(['type' => User::ADMIN]);

        $this->assertTrue($user->isAdmin());
        $this->assertSame('admin', $user->role);
    }

    /** @test */
    public function a_user_has_medical_forms()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->medicalForms);
    }

    /** @test */
    public function a_user_has_appointments()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->appointments);
    }
}
