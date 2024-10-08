<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // 2024_10_07_XXXXXX_add_storage_gb_to_packages_table.php
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('storage_gb')->nullable(); // GB cinsinden depolama alanı
        });
    }

    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('storage_gb');
        });
    }
};
