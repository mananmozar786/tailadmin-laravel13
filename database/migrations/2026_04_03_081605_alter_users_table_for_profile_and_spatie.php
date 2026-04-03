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
            $table->dropColumn(['name', 'role']);
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('last_name');
            $table->text('address')->nullable()->after('gender');
            $table->integer('city_id')->nullable()->after('address');
            $table->integer('state_id')->nullable()->after('city_id');
            $table->integer('country_id')->nullable()->after('state_id');
            $table->string('phone_country_code')->nullable()->after('country_id');
            $table->string('phone')->nullable()->after('phone_country_code');
            $table->string('zipcode')->nullable()->after('phone');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('zipcode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'gender',
                'address',
                'city_id',
                'state_id',
                'country_id',
                'phone_country_code',
                'phone',
                'zipcode',
                'status'
            ]);
            $table->string('name')->after('id');
            $table->enum('role', ['user', 'admin', 'manager'])->default('user')->after('password');
        });
    }
};
