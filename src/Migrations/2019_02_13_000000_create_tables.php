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
            $table->uuid('user_id')->unique();
            $table->string('slug')->unique();
            $table->string('full_name');
            $table->string('qualification');
            $table->date('practicing_from');
            $table->text('professional_statement')->nullable();
            $table->boolean('is_active')->default(1);
            $table->text('working_hours_rule');
            $table->timestamps();
        });

        Schema::create('reliqui_specializations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('reliqui_doctors_specializations', function (Blueprint $table) {
            $table->uuid('doctor_id');
            $table->uuid('specialization_id');

            $table->unique(['doctor_id', 'specialization_id'], 'doctor_id_specialization_id_unique');
        });

        Schema::create('reliqui_medical_forms', function (Blueprint $table) {
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

        Schema::create('reliqui_health_facilities', function (Blueprint $table) {
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

        Schema::create('reliqui_invitations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->string('role');
            $table->string('token')->unique();
            $table->timestamps();
        });

        Schema::create('reliqui_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('doctor_id');
            $table->uuid('health_facility_id');
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->integer('estimated_service_time_in_minutes')->nullable();
            $table->timestamps();

            $table->unique(['doctor_id', 'health_facility_id']);
        });

        Schema::create('reliqui_bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('schedule_id');
            $table->uuid('medical_form_id');
            $table->dateTime('preferred_date_time');
            $table->dateTime('actual_end_date_time')->nullable();
            $table->string('description')->nullable();
            $table->smallInteger('status', false, true)->default(2);
            $table->timestamps();

            $table->index(['schedule_id', 'medical_form_id']);
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
        Schema::dropIfExists('reliqui_specializations');
        Schema::dropIfExists('reliqui_doctors_specializations');
        Schema::dropIfExists('reliqui_medical_forms');
        Schema::dropIfExists('reliqui_health_facilities');
        Schema::dropIfExists('reliqui_invitations');
        Schema::dropIfExists('reliqui_schedules');
        Schema::dropIfExists('reliqui_bookings');
    }
}
