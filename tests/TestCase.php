<?php

namespace Reliqui\Ambulatory\Tests;

use Reliqui\Ambulatory\User;
use Reliqui\Ambulatory\Doctor;
use Reliqui\Ambulatory\AmbulatoryServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/Factories');

        $this->artisan('migrate', ['--database' => 'ambulatory']);
    }

    protected function getPackageProviders($app)
    {
        return [
            AmbulatoryServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'ambulatory');
        $app['config']->set('database.connections.ambulatory', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function signInAsAdmin($admin = null)
    {
        $admin = $admin ?: factory(User::class)->create(['type' => User::ADMIN]);

        $this->actingAs($admin, 'ambulatory');

        return $admin;
    }

    protected function signInAsDoctor($doctor = null)
    {
        $doctor = $doctor ?: factory(User::class)->create(['type' => User::DOCTOR]);

        factory(Doctor::class)->create(['user_id' => $doctor->id]);

        $this->actingAs($doctor, 'ambulatory');

        return $doctor;
    }

    protected function signInAsPatient($patient = null)
    {
        $patient = $patient ?: factory(User::class)->create(['type' => User::PATIENT]);

        $this->actingAs($patient, 'ambulatory');

        return $patient;
    }
}
