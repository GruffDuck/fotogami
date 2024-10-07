<?php
// database/migrations/xxxx_xx_xx_add_space_columns_to_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpaceColumnsToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('freeSpace')->nullable();
            $table->integer('fullSpace')->nullable();
            $table->integer('usedSpace')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['freeSpace', 'fullSpace', 'usedSpace']);
        });
    }
}
