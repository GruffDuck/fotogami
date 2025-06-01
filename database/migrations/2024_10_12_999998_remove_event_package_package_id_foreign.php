<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('event_package', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            // Foreign key kaldırıldıktan sonra, gerekirse aşağıdaki satırı da ekleyebilirsin:
            // $table->unsignedBigInteger('package_id')->change();
        });
    }

    public function down()
    {
        Schema::table('event_package', function (Blueprint $table) {
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }
}; 