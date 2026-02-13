<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('medicine_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained()->cascadeOnDelete();
            $table->string('patient_type'); // App\Models\Student or App\Models\Personnel
            $table->unsignedBigInteger('patient_id');
            $table->integer('quantity');
            $table->foreignId('dispensed_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('dispensed_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['patient_type', 'patient_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicine_logs');
    }
};
