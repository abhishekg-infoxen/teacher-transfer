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
            $table->string('ehrms_code')->unique()->nullable()->after('email'); // Making unique but nullable for flexibility during dev? Or strict?
            // EHRMS should be mandatory for teachers, but maybe existing users don't have it? 
            // I'll make nullable first then stricter later if needed, but user said "register... with EHRMS".
            // Let's make it nullable on migration then user fills it.

            $table->string('phone')->nullable()->after('ehrms_code');

            // Current Posting
            $table->string('current_district')->nullable()->after('phone');
            $table->string('current_block')->nullable()->after('current_district');
            $table->string('current_school')->nullable()->after('current_block');

            // Desired Posting
            $table->string('desired_district')->nullable()->after('current_school');
            $table->string('desired_block')->nullable()->after('desired_district');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'ehrms_code',
                'phone',
                'current_district',
                'current_block',
                'current_school',
                'desired_district',
                'desired_block',
            ]);
        });
    }
};
