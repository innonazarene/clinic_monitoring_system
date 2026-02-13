<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->string('patient_type'); // App\Models\Student or App\Models\Personnel
            $table->unsignedBigInteger('patient_id');
            $table->string('diagnosis');
            $table->text('treatment_given')->nullable();
            $table->text('medication_given')->nullable();
            $table->foreignId('treated_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('treated_at');
            $table->text('notes')->nullable();
            $table->string('status')->default('completed'); // completed, follow-up
            $table->timestamps();

            $table->index(['patient_type', 'patient_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
