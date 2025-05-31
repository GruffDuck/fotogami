<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name')->nullable();
            $table->date('date');
            $table->string('time')->nullable();
            $table->string('address');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->integer('expected_guests');
            $table->boolean('is_public_sharing_allowed');
            $table->enum('media_access_level', ['qr', 'password', 'public']);
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->string('type'); // wedding, graduation, corporate, art, travel
        });

        Schema::create('wedding_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('bride_name');
            $table->string('groom_name');
            $table->string('venue_name');
            $table->string('photo_package_type')->nullable();
        });

        Schema::create('graduation_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('student_name');
            $table->string('school_name');
            $table->string('grade_level');
            $table->string('teacher_name')->nullable();
        });

        Schema::create('corporate_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('organization_name');
            $table->string('event_theme')->nullable();
        });

        Schema::create('corporate_event_sponsors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corporate_event_id')->constrained('corporate_events')->onDelete('cascade');
            $table->string('sponsor_name');
        });

        Schema::create('corporate_event_speakers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('corporate_event_id')->constrained('corporate_events')->onDelete('cascade');
            $table->string('speaker_name');
        });

        Schema::create('art_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('artist_or_group_name');
            $table->string('performance_type');
            $table->boolean('ticket_required');
        });

        Schema::create('travel_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('trip_type');
            $table->boolean('surprise_planned');
            $table->string('partner_name');
            $table->string('destination_name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('travel_events');
        Schema::dropIfExists('art_events');
        Schema::dropIfExists('corporate_event_speakers');
        Schema::dropIfExists('corporate_event_sponsors');
        Schema::dropIfExists('corporate_events');
        Schema::dropIfExists('graduation_events');
        Schema::dropIfExists('wedding_events');
        Schema::dropIfExists('events');
    }
};
