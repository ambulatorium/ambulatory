<?php

namespace Ambulatory\Tests\Unit;

use Illuminate\Support\Collection;
Use Ambulatory\Specialization;
Use Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpecializationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_uuid_when_creating_a_new_specialization()
    {
        $specialization = factory(Specialization::class)->create(['id' => '']);

        $this->assertNotNull($specialization->id);
    }

    /** @test */
    public function it_generate_the_slug_when_saving_a_new_specialization()
    {
        $specialization = factory(Specialization::class)->create(['name' => 'Emergency radiology']);

        $this->assertSame('emergency-radiology', $specialization->slug);

        $specialization = factory(Specialization::class)->create(['name' => 'Emergency radiology']);

        $this->assertSame('emergency-radiology-0', $specialization->slug);
    }

    /** @test */
    public function it_generate_the_slug_with_a_title_that_ends_in_a_number()
    {
        $specialization = factory(Specialization::class)->create(['name' => 'DERMATOLOGY 13']);

        $this->assertSame('dermatology-13', $specialization->slug);

        $specialization = factory(Specialization::class)->create(['name' => 'DERMATOLOGY 13']);

        $this->assertSame('dermatology-13-0', $specialization->slug);
    }

    /** @test */
    public function it_belongs_to_the_doctors()
    {
        $specialization = factory(Specialization::class)->create();

        $this->assertInstanceOf(Collection::class, $specialization->doctors);
    }
}
