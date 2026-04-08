<?php

namespace App\Services;

class HealthService
{
    /**
     * Calculate BMI (Body Mass Index).
     *
     * @param float $heightCm
     * @param float $weightKg
     * @return float
     */
    public function calculateBmi(float $heightCm, float $weightKg): float
    {
        $heightInMeters = $heightCm / 100;
        $bmi = $weightKg / ($heightInMeters * $heightInMeters);

        return round($bmi, 2);
    }

    /**
     * Determine BMI Status based on BMI value.
     *
     * @param float $bmi
     * @return string
     */
    public function getBmiStatus(float $bmi): string
    {
        if ($bmi < 18.5) {
            return 'Underweight';
        }

        if ($bmi >= 18.5 && $bmi <= 24.9) {
            return 'Normal';
        }

        if ($bmi >= 25 && $bmi <= 29.9) {
            return 'Overweight';
        }

        return 'Obese';
    }
}
