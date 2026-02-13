<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->morphs('recordable'); // recordable_type, recordable_id (Student or Personnel)
            $table->date('examination_date')->nullable();

            // Physical Examination
            $table->decimal('height_cm', 5, 1)->nullable();
            $table->decimal('weight_kg', 5, 1)->nullable();
            $table->decimal('bmi', 5, 2)->nullable();
            $table->string('bmi_category')->nullable(); // Underweight, Normal, Overweight, Obese
            $table->string('pulse_rate')->nullable();
            $table->string('respiratory_rate')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->decimal('oxygen_saturation', 5, 2)->nullable();

            // Lifestyle
            $table->boolean('smoker')->default(false);
            $table->boolean('alcoholic')->default(false);

            // Allergies
            $table->text('allergies')->nullable();
            $table->boolean('food_allergy')->default(false);
            $table->boolean('drug_allergy')->default(false);

            // Medical History
            $table->text('past_medical_history')->nullable();

            // Family History
            $table->boolean('family_hpn')->default(false);
            $table->boolean('family_cancer')->default(false);
            $table->boolean('family_asthma')->default(false);
            $table->boolean('family_dm')->default(false);

            // Physician Info
            $table->string('physician_name')->nullable();
            $table->date('physician_date')->nullable();
            $table->string('physician_license_no')->nullable();
            $table->string('physician_ptr')->nullable();
            $table->date('license_expiry_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
