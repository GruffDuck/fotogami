<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_id');
            $table->string('package_name');
            $table->string('storage_description');
            $table->string('upload_time_description');
            $table->integer('upload_time_days'); // Gün cinsinden upload time
            $table->string('storage_time_description');
            $table->integer('storage_time_days'); // Gün cinsinden storage time
            $table->string('price');
            $table->string('background_color')->nullable();
            $table->string('box_bg')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
