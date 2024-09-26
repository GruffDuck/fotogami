<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'code']; // Burada email alanını ekliyoruz
    public function up()
    {
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('code');
            $table->timestamp('expires_at')->nullable(); // Make sure this is nullable or has a default value
            $table->timestamps();
        });
    }
}
