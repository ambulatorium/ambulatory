<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulatory_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->smallInteger('type', false, true)->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('ambulatory_doctors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();
            $table->string('slug')->unique();
            $table->string('full_name');
            $table->string('qualification');
            $table->date('practicing_from');
            $table->text('professional_statement')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('working_hours_rule');
            $table->timestamps();
        });

        Schema::create('ambulatory_specializations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('ambulatory_doctors_specializations', function (Blueprint $table) {
            $table->uuid('doctor_id');
            $table->uuid('specialization_id');
            // $table->timestamps();

            $table->unique(['doctor_id', 'specialization_id'], 'doctor_id_specialization_id_unique');
        });

        Schema::create('ambulatory_medical_forms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->string('slug')->unique();
            $table->string('form_name')->index();
            $table->string('full_name');
            $table->date('dob');
            $table->string('gender');
            $table->text('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zip_code');
            $table->string('home_phone')->nullable();
            $table->string('cell_phone');
            $table->string('marital_status');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('ambulatory_health_facilities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');
            $table->string('zip_code');
            $table->timestamps();
        });

        Schema::create('ambulatory_invitations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->string('role');
            $table->string('token')->unique();
            $table->timestamps();
        });

        Schema::create('ambulatory_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('doctor_id');
            $table->uuid('health_facility_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('estimated_service_time_in_minutes')->nullable();
            $table->timestamps();

            $table->unique(['doctor_id', 'health_facility_id']);
        });

        // to store custom availabilities of schedule.
        Schema::create('ambulatory_availabilities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('schedule_id')->index();
            $table->string('type')->default('date');
            $table->text('intervals');
            $table->date('date');
            $table->timestamps();
        });

        Schema::create('ambulatory_bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('schedule_id');
            $table->uuid('medical_form_id')->index();
            $table->dateTime('preferred_date_time');
            $table->dateTime('actual_end_date_time')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['schedule_id', 'preferred_date_time'], 'book_schedule_date_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ambulatory_users');
        Schema::dropIfExists('ambulatory_doctors');
        Schema::dropIfExists('ambulatory_specializations');
        Schema::dropIfExists('ambulatory_doctors_specializations');
        Schema::dropIfExists('ambulatory_medical_forms');
        Schema::dropIfExists('ambulatory_health_facilities');
        Schema::dropIfExists('ambulatory_invitations');
        Schema::dropIfExists('ambulatory_schedules');
        Schema::dropIfExists('ambulatory_availabilities');
        Schema::dropIfExists('ambulatory_bookings');
    }
}
