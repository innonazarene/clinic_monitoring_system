<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'recordable_type', 'recordable_id', 'examination_date',
        'height_cm', 'weight_kg', 'bmi', 'bmi_category',
        'pulse_rate', 'respiratory_rate', 'blood_pressure', 'oxygen_saturation',
        'smoker', 'alcoholic', 'allergies', 'food_allergy', 'drug_allergy',
        'past_medical_history', 'family_hpn', 'family_cancer', 'family_asthma', 'family_dm',
        'physician_name', 'physician_date', 'physician_license_no', 'physician_ptr',
        'license_expiry_date',
    ];

    protected function casts(): array
    {
        return [
            'examination_date' => 'date',
            'physician_date' => 'date',
            'license_expiry_date' => 'date',
            'smoker' => 'boolean',
            'alcoholic' => 'boolean',
            'food_allergy' => 'boolean',
            'drug_allergy' => 'boolean',
            'family_hpn' => 'boolean',
            'family_cancer' => 'boolean',
            'family_asthma' => 'boolean',
            'family_dm' => 'boolean',
            'height_cm' => 'decimal:1',
            'weight_kg' => 'decimal:1',
            'bmi' => 'decimal:2',
            'oxygen_saturation' => 'decimal:2',
        ];
    }

    public function recordable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Calculate BMI from height (cm) and weight (kg).
     */
    public static function calculateBmi(float $heightCm, float $weightKg): array
    {
        if ($heightCm <= 0 || $weightKg <= 0) {
            return ['bmi' => 0, 'category' => 'N/A'];
        }

        $heightM = $heightCm / 100;
        $bmi = round($weightKg / ($heightM * $heightM), 2);

        $category = match (true) {
                $bmi < 18.5 => 'Underweight',
                $bmi < 25.0 => 'Normal',
                $bmi < 30.0 => 'Overweight',
                default => 'Obese',
            };

        return ['bmi' => $bmi, 'category' => $category];
    }

    public function hasAllergies(): bool
    {
        return !empty($this->allergies) || $this->food_allergy || $this->drug_allergy;
    }
}
