<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wedding_events', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('graduation_events', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('corporate_events', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('art_events', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('travel_events', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('corporate_event_sponsors', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('corporate_event_speakers', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('wedding_events', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('graduation_events', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('corporate_events', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('art_events', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('travel_events', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('corporate_event_sponsors', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('corporate_event_speakers', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}; 