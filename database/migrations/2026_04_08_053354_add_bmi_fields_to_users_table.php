<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('height', 8, 2)->nullable()->after('zipcode');
            $table->decimal('weight', 8, 2)->nullable()->after('height');
            $table->decimal('bmi', 8, 2)->nullable()->after('weight');
            $table->string('bmi_status')->nullable()->after('bmi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['height', 'weight', 'bmi', 'bmi_status']);
        });
    }
};
