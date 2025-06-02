<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('event_package', function (Blueprint $table) {
            $table->integer('storage_gb')->nullable();
            $table->integer('storage_duration_days')->nullable();
        });
    }

    public function down()
    {
        Schema::table('event_package', function (Blueprint $table) {
            $table->dropColumn(['storage_gb', 'storage_duration_days']);
        });
    }
};
