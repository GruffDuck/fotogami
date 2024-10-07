<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('organization_id'); // organization_id'yi kaldırıyoruz
            $table->string('organization_name')->nullable(); // organization_name alanını ekliyoruz
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('organization_id')->nullable();
            $table->dropColumn('organization_name');
        });
    }
};
