<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // 2024_10_07_XXXXXX_add_guests_count_to_products_table.php
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('guests_count')->nullable(); // Misafir sayısı
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('guests_count');
        });
    }
};
