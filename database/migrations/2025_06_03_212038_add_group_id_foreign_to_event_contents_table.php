<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Önce tablo ve kolon tiplerini kontrol et
        // Sonra foreign key ekle
        Schema::table('event_contents', function (Blueprint $table) {
            // Eğer group_id kolonu yoksa ekle (güvenlik için)
            if (!Schema::hasColumn('event_contents', 'group_id')) {
                $table->unsignedBigInteger('group_id')->nullable()->after('user_id');
            }
            $table->foreign('group_id')->references('id')->on('event_groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_contents', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
        });
    }
};
