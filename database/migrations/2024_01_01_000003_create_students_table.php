<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id_number')->unique();
            $table->string('name');
            $table->date('birthdate')->nullable();
            $table->text('address')->nullable();
            $table->integer('age')->nullable();
            $table->enum('sex', ['Male', 'Female'])->nullable();
            $table->string('civil_status')->nullable();
            $table->string('religion')->nullable();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->string('contact_no')->nullable();
            $table->string('year_level')->nullable();

            // Emergency Contact
            $table->string('emergency_contact_person')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->text('emergency_contact_address')->nullable();
            $table->string('emergency_contact_no')->nullable();

            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
