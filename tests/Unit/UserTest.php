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
    public function a_user_has_medical_forms()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->medicalForms);
    }
}
