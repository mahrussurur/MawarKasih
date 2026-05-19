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
        Schema::table('donaturs', function (Blueprint $table) {
            if (!Schema::hasColumn('donaturs', 'password')) {
                $table->string('password')->nullable()->after('alamat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donaturs', function (Blueprint $table) {
            if (Schema::hasColumn('donaturs', 'password')) {
                $table->dropColumn('password');
            }
        });
    }
};
