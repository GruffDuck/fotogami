<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // 2024_10_07_XXXXXX_add_guests_count_and_description_to_products_table.php
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable();     // Ürün açıklaması
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
