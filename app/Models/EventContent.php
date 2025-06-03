<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'group_id',
        'type',
        'file_path',
        'description',
        'uploaded_at',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(EventGroup::class, 'group_id');
    }
}
