<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('event_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('uploader_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['image', 'video', 'file']);
            $table->string('url');
            $table->string('file_name');
            $table->string('mime_type');
            $table->bigInteger('size');
            $table->timestamp('created_at')->useCurrent();
            $table->text('description')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->integer('duration')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_media');
    }
}; 