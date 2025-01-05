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
        Schema::table('sub_services_lang', function (Blueprint $table) {
            $table->text('title')->nullable()->change();
            $table->text('second_title')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->text('key_features')->nullable()->change();
            $table->text('use_cases')->nullable()->change();
            $table->text('benefits')->nullable()->change();
            $table->text('why_us')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
