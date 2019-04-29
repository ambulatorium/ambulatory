<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reliqui_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->smallInteger('type', false, true)->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('reliqui_doctors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('full_name');
            $table->string('years_of_experience');
            $table->string('qualification');
            $table->string('bio')->nullable();
            $table->boolean('is_active')->default(1);
            $table->uuid('user_id')->index();
            $table->timestamps();
        });

        Schema::create('reliqui_specialities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('reliqui_doctors_specialities', function (Blueprint $table) {
            $table->uuid('doctor_id');
            $table->uuid('speciality_id');

            $table->unique(['doctor_id', 'speciality_id']);
        });

        Schema::create('reliqui_patients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('form_name')->index();
            $table->string('patient_full_name');
            $table->date('dob');
            $table->string('gender');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('home_phone')->nullable();
            $table->string('cell_phone');
            $table->string('marital_status');
            $table->boolean('is_verified')->default(0);
            $table->uuid('user_id')->index();
            $table->timestamps();
        });

        Schema::create('reliqui_healthcare_locations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');
            $table->string('zip_code');
            $table->timestamps();
        });

        Schema::create('reliqui_invitations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->string('role');
            $table->string('token')->unique();
            $table->timestamps();
        });

        Schema::create('reliqui_working_hours', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->integer('estimated_service_time_in_minutes')->nullable();
            $table->boolean('repeat')->default(0);
            $table->text('recurrence')->nullable();
            $table->timestamps();

            $table->uuid('doctor_id');
            $table->uuid('location_id');
            $table->unique(['doctor_id', 'location_id']);
        });

        Schema::create('reliqui_appointments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('patient_id')->index();
            $table->dateTime('preferred_date_time');
            $table->boolean('scheduled')->default(1);
            $table->uuid('schedule_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reliqui_users');
        Schema::dropIfExists('reliqui_doctors');
        Schema::dropIfExists('reliqui_specialities');
        Schema::dropIfExists('reliqui_doctors_specialities');
        Schema::dropIfExists('reliqui_patients');
        Schema::dropIfExists('reliqui_healthcare_locations');
        Schema::dropIfExists('reliqui_invitations');
        Schema::dropIfExists('reliqui_working_hours');
        Schema::dropIfExists('reliqui_appointments');
    }
}
