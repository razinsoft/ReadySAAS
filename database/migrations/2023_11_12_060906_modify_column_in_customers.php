<?php

use App\Models\CustomerGroup;
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
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['customer_group_id']);
            $table->unsignedBigInteger('customer_group_id')->nullable(true)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('phone_number')->nullable(true)->change();
            $table->string('city')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
           $table->string('email')->nullable()->change();
           $table->string('city')->change();
           $table->string('phone_number')->change();
        });
    }
};
